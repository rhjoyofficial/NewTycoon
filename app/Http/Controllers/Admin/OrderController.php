<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Services\PaymentService;

class OrderController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    )
    {
        $this->middleware(['auth', 'role:admin']);
    }
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->byPaymentStatus($request->payment_status);
        }

        // Filter by date range
        if ($request->filled('date_range')) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', today()->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month)
                        ->whereYear('created_at', now()->year);
                    break;
            }
        }

        // Get statistics for dashboard
        $stats = [
            'total' => Order::count(),
            'completed' => Order::byStatus('completed')->count(),
            'pending' => Order::byStatus('pending')->count(),
            'processing' => Order::byStatus('processing')->count(),
            'cancelled' => Order::byStatus('cancelled')->count(),
        ];

        $pendingPayments = Order::byPaymentStatus('pending')->count();
        $todayOrders = Order::whereDate('created_at', today())->count();

        // Paginate orders
        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders', 'stats', 'pendingPayments', 'todayOrders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $customers = User::whereRole('customer')->get();
        $products = Product::active()->inStock()->get();

        return view('admin.orders.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',

            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_country' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',

            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_name' => 'nullable|required_if:billing_same_as_shipping,false|string|max:255',
            'billing_email' => 'nullable|required_if:billing_same_as_shipping,false|email|max:255',
            'billing_phone' => 'nullable|string|max:20',
            'billing_address_line1' => 'nullable|required_if:billing_same_as_shipping,false|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|required_if:billing_same_as_shipping,false|string|max:100',
            'billing_state' => 'nullable|required_if:billing_same_as_shipping,false|string|max:100',
            'billing_country' => 'nullable|required_if:billing_same_as_shipping,false|string|max:100',
            'billing_zip_code' => 'nullable|required_if:billing_same_as_shipping,false|string|max:20',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',

            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',

            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
            'status' => 'required|string|in:pending,processing,on_hold,completed,cancelled,refunded',

            'shipping_method' => 'required|string|max:100',
            'customer_note' => 'nullable|string',
            'admin_note' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],

                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address_line1' => $validated['shipping_address_line1'],
                'shipping_address_line2' => $validated['shipping_address_line2'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_country' => $validated['shipping_country'],
                'shipping_zip_code' => $validated['shipping_zip_code'],

                'billing_same_as_shipping' => $validated['billing_same_as_shipping'] ?? false,
                'billing_name' => $validated['billing_same_as_shipping'] ? $validated['shipping_name'] : $validated['billing_name'],
                'billing_email' => $validated['billing_same_as_shipping'] ? $validated['shipping_email'] : $validated['billing_email'],
                'billing_phone' => $validated['billing_same_as_shipping'] ? $validated['shipping_phone'] : $validated['billing_phone'],
                'billing_address_line1' => $validated['billing_same_as_shipping'] ? $validated['shipping_address_line1'] : $validated['billing_address_line1'],
                'billing_address_line2' => $validated['billing_same_as_shipping'] ? $validated['shipping_address_line2'] : $validated['billing_address_line2'],
                'billing_city' => $validated['billing_same_as_shipping'] ? $validated['shipping_city'] : $validated['billing_city'],
                'billing_state' => $validated['billing_same_as_shipping'] ? $validated['shipping_state'] : $validated['billing_state'],
                'billing_country' => $validated['billing_same_as_shipping'] ? $validated['shipping_country'] : $validated['billing_country'],
                'billing_zip_code' => $validated['billing_same_as_shipping'] ? $validated['shipping_zip_code'] : $validated['billing_zip_code'],

                'subtotal' => $validated['subtotal'],
                'shipping_cost' => $validated['shipping_cost'],
                'tax_amount' => $validated['tax_amount'],
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'total_amount' => $validated['total_amount'],

                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'status' => $validated['status'],

                'shipping_method' => $validated['shipping_method'],
                'customer_note' => $validated['customer_note'],
                'admin_note' => $validated['admin_note'],

                'paid_at' => $validated['payment_status'] === 'paid' ? now() : null,
                'processing_at' => $validated['status'] === 'processing' ? now() : null,
            ]);

            // Create order items
            foreach ($validated['items'] as $itemData) {
                $product = Product::findOrFail($itemData['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    'attributes' => $itemData['attributes'] ?? [],
                ]);

                $product->reserveStock($itemData['quantity']);
                $product->recordSale($itemData['quantity'], (float) $itemData['unit_price']);
            }

            $this->paymentService->createPendingPayment($order, $validated['payment_method']);

            if ($validated['payment_status'] !== 'pending') {
                $this->paymentService->syncOrderPaymentStatus($order, $validated['payment_status']);
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to create order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load('items', 'transactions');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $order->load('items');
        $products = Product::active()->inStock()->get();

        return view('admin.orders.edit', compact('order', 'products'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',

            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address_line1' => 'required|string|max:255',
            'shipping_address_line2' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_country' => 'required|string|max:100',
            'shipping_zip_code' => 'required|string|max:20',

            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_name' => 'nullable|required_if:billing_same_as_shipping,false|string|max:255',
            'billing_email' => 'nullable|required_if:billing_same_as_shipping,false|email|max:255',
            'billing_phone' => 'nullable|string|max:20',
            'billing_address_line1' => 'nullable|required_if:billing_same_as_shipping,false|string|max:255',
            'billing_address_line2' => 'nullable|string|max:255',
            'billing_city' => 'nullable|required_if:billing_same_as_shipping,false|string|max:100',
            'billing_state' => 'nullable|required_if:billing_same_as_shipping,false|string|max:100',
            'billing_country' => 'nullable|required_if:billing_same_as_shipping,false|string|max:100',
            'billing_zip_code' => 'nullable|required_if:billing_same_as_shipping,false|string|max:20',

            'items' => 'required|array|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',

            'new_items' => 'nullable|array',
            'new_items.*.product_id' => 'nullable|exists:products,id',
            'new_items.*.unit_price' => 'required|numeric|min:0',
            'new_items.*.quantity' => 'required|integer|min:1',
            'new_items.*.product_name' => 'nullable|string|max:255',
            'new_items.*.product_sku' => 'nullable|string|max:100',

            'shipping_cost' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',

            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded,partially_refunded',
            'status' => 'required|string|in:pending,processing,on_hold,completed,cancelled,refunded',

            'shipping_method' => 'required|string|max:100',
            'customer_note' => 'nullable|string',
            'admin_note' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Update order
            $order->update([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],

                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_address_line1' => $validated['shipping_address_line1'],
                'shipping_address_line2' => $validated['shipping_address_line2'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_state' => $validated['shipping_state'],
                'shipping_country' => $validated['shipping_country'],
                'shipping_zip_code' => $validated['shipping_zip_code'],

                'billing_same_as_shipping' => $validated['billing_same_as_shipping'] ?? false,
                'billing_name' => $validated['billing_same_as_shipping'] ? $validated['shipping_name'] : $validated['billing_name'],
                'billing_email' => $validated['billing_same_as_shipping'] ? $validated['shipping_email'] : $validated['billing_email'],
                'billing_phone' => $validated['billing_same_as_shipping'] ? $validated['shipping_phone'] : $validated['billing_phone'],
                'billing_address_line1' => $validated['billing_same_as_shipping'] ? $validated['shipping_address_line1'] : $validated['billing_address_line1'],
                'billing_address_line2' => $validated['billing_same_as_shipping'] ? $validated['shipping_address_line2'] : $validated['billing_address_line2'],
                'billing_city' => $validated['billing_same_as_shipping'] ? $validated['shipping_city'] : $validated['billing_city'],
                'billing_state' => $validated['billing_same_as_shipping'] ? $validated['shipping_state'] : $validated['billing_state'],
                'billing_country' => $validated['billing_same_as_shipping'] ? $validated['shipping_country'] : $validated['billing_country'],
                'billing_zip_code' => $validated['billing_same_as_shipping'] ? $validated['shipping_zip_code'] : $validated['billing_zip_code'],

                'shipping_cost' => $validated['shipping_cost'],
                'discount_amount' => $validated['discount_amount'] ?? 0,
                'tax_amount' => $validated['tax_amount'],

                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'status' => $validated['status'],

                'shipping_method' => $validated['shipping_method'],
                'customer_note' => $validated['customer_note'],
                'admin_note' => $validated['admin_note'],
            ]);

            // Update existing items
            $subtotal = 0;
            foreach ($validated['items'] as $itemId => $itemData) {
                $item = OrderItem::find($itemId);
                if ($item && $item->order_id === $order->id) {
                    $oldQuantity = $item->quantity;

                    $item->update([
                        'unit_price' => $itemData['unit_price'],
                        'quantity' => $itemData['quantity'],
                        'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    ]);

                    $subtotal += $item->total_price;
                }
            }

            // Add new items
            if (!empty($validated['new_items'])) {
                foreach ($validated['new_items'] as $itemData) {
                    if (!empty($itemData['product_id'])) {
                        $product = Product::find($itemData['product_id']);
                        $productName = $product->name;
                        $productSku = $product->sku;

                        $product->reserveStock($itemData['quantity']);
                        $product->recordSale($itemData['quantity'], (float) $itemData['unit_price']);
                    } else {
                        $productName = $itemData['product_name'];
                        $productSku = $itemData['product_sku'];
                    }

                    $item = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $itemData['product_id'] ?? null,
                        'product_name' => $productName,
                        'product_sku' => $productSku,
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total_price' => $itemData['quantity'] * $itemData['unit_price'],
                    ]);

                    $subtotal += $item->total_price;
                }
            }

            // Update order totals
            $order->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal + $validated['shipping_cost'] + $validated['tax_amount'] - ($validated['discount_amount'] ?? 0),
            ]);

            $this->paymentService->syncOrderPaymentStatus($order, $validated['payment_status']);

            DB::commit();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to update order. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            // Restock products before deleting
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->reverseSale($item->quantity, (float) $item->unit_price);
                }
            }

            // Delete associated records
            $order->items()->delete();
            $order->transactions()->delete();

            // Delete order
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order deletion failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to delete order. Please try again.');
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,on_hold,completed,cancelled,refunded',
        ]);

        $status = $request->status;
        $oldStatus = $order->status;

        DB::beginTransaction();
        try {
            switch ($status) {
                case 'processing':
                    $order->markAsProcessing();
                    break;
                case 'completed':
                    $order->markAsDelivered();
                    break;
                case 'cancelled':
                    $order->cancel();
                    break;
                default:
                    $order->update(['status' => $status]);
            }

            // Log status change
            activity()
                ->performedOn($order)
                ->causedBy(auth()->user())
                ->withProperties(['old_status' => $oldStatus, 'new_status' => $status])
                ->log('Order status updated');

            DB::commit();

            return back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order status update failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to update order status.');
        }
    }

    /**
     * Update payment status.
     */
    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed,refunded,partially_refunded',
        ]);

        DB::beginTransaction();
        try {
            $this->paymentService->syncOrderPaymentStatus($order, $request->payment_status);

            DB::commit();

            return back()->with('success', 'Payment status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment status update failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to update payment status.');
        }
    }

    /**
     * Add note to order.
     */
    public function addNote(Request $request, Order $order)
    {
        $request->validate([
            'note' => 'required|string',
            'type' => 'required|in:customer,admin',
        ]);

        $field = $request->type === 'customer' ? 'customer_note' : 'admin_note';
        $currentNote = $order->$field;

        $note = $currentNote ? $currentNote . "\n---\n" . now()->format('Y-m-d H:i') . ": " . $request->note
            : now()->format('Y-m-d H:i') . ": " . $request->note;

        $order->update([$field => $note]);

        return back()->with('success', 'Note added successfully.');
    }

    /**
     * Send invoice to customer.
     */
    public function sendInvoice(Order $order)
    {
        try {
            // Here you would implement email sending logic
            // For example: Mail::to($order->customer_email)->send(new OrderInvoiceMail($order));

            return back()->with('success', 'Invoice sent to customer.');
        } catch (\Exception $e) {
            Log::error('Invoice sending failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send invoice.');
        }
    }

    /**
     * Resend order confirmation.
     */
    public function resendConfirmation(Order $order)
    {
        try {
            // Here you would implement email sending logic
            // For example: Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));

            return back()->with('success', 'Order confirmation resent.');
        } catch (\Exception $e) {
            Log::error('Order confirmation resend failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to resend confirmation.');
        }
    }

    /**
     * Mark order as shipped.
     */
    public function ship(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:100',
            'carrier' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $order->markAsShipped($request->tracking_number, $request->carrier);

            DB::commit();

            return back()->with('success', 'Order marked as shipped.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order shipping failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to mark order as shipped.');
        }
    }

    /**
     * Cancel order.
     */
    public function cancel(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $order->cancel($request->reason);

            DB::commit();

            return back()->with('success', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order cancellation failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to cancel order.');
        }
    }

    /**
     * Refund order.
     */
    public function refund(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'nullable|numeric|min:0|max:' . $order->total_amount,
            'full' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $full = $request->filled('full') ? $request->full : true;
            $amount = $full ? null : $request->amount;

            $order->refund($amount, $full);

            DB::commit();

            return back()->with('success', 'Order refunded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order refund failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to refund order.');
        }
    }

    /**
     * Add item to order.
     */
    public function addItem(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            $unitPrice = $request->unit_price ?? $product->price;

            $item = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'total_price' => $request->quantity * $unitPrice,
            ]);

            $product->reserveStock($request->quantity);
            $product->recordSale($request->quantity, (float) $unitPrice);

            // Update order totals
            $newSubtotal = $order->subtotal + $item->total_price;
            $order->update([
                'subtotal' => $newSubtotal,
                'total_amount' => $newSubtotal + $order->shipping_cost + $order->tax_amount - $order->discount_amount,
            ]);

            DB::commit();

            return back()->with('success', 'Item added to order.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Add item to order failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to add item to order.');
        }
    }

    /**
     * Update order item.
     */
    public function updateItem(Request $request, Order $order, OrderItem $item)
    {
        if ($item->order_id !== $order->id) {
            abort(404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $oldQuantity = $item->quantity;
            $newQuantity = $request->quantity;

            // Update item
            $item->update([
                'quantity' => $newQuantity,
                'unit_price' => $request->unit_price,
                'total_price' => $newQuantity * $request->unit_price,
            ]);

            // Update product stock if product exists
            if ($item->product) {
                $quantityDiff = $newQuantity - $oldQuantity;
                if ($quantityDiff > 0) {
                    $item->product->reserveStock($quantityDiff);
                    $item->product->recordSale($quantityDiff, (float) $request->unit_price);
                } elseif ($quantityDiff < 0) {
                    $item->product->reverseSale(abs($quantityDiff), (float) $request->unit_price);
                }
            }

            // Update order totals
            $subtotal = $order->items->sum('total_price');
            $order->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal + $order->shipping_cost + $order->tax_amount - $order->discount_amount,
            ]);

            DB::commit();

            return back()->with('success', 'Order item updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order item update failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to update order item.');
        }
    }

    /**
     * Delete order item.
     */
    public function deleteItem(Order $order, OrderItem $item)
    {
        if ($item->order_id !== $order->id) {
            abort(404);
        }

        DB::beginTransaction();
        try {
            // Restock product
            if ($item->product) {
                $item->product->reverseSale($item->quantity, (float) $item->unit_price);
            }

            // Delete item
            $item->delete();

            // Update order totals
            $subtotal = $order->items->sum('total_price');
            $order->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal + $order->shipping_cost + $order->tax_amount - $order->discount_amount,
            ]);

            DB::commit();

            return back()->with('success', 'Item removed from order.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order item deletion failed: ' . $e->getMessage());

            return back()->with('error', 'Failed to remove item from order.');
        }
    }

    /**
     * Export orders.
     */
    public function export(Request $request)
    {
        $query = Order::with('items');

        // Apply filters
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }
        if ($request->filled('payment_status')) {
            $query->byPaymentStatus($request->payment_status);
        }
        if ($request->filled('date_range')) {
            // Apply date range filter
        }

        $orders = $query->get();

        // Here you would implement CSV/Excel export logic
        // For example: return (new OrdersExport($orders))->download('orders.csv');

        return back()->with('success', 'Export feature would be implemented here.');
    }

    /**
     * Vendor orders view.
     */
    public function vendor(Request $request)
    {
        // This would filter orders to only show those with products from the logged-in vendor
        $vendorId = Auth::id();

        $query = Order::whereHas('items', function ($q) use ($vendorId) {
            $q->whereHas('product', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            });
        })->latest();

        // Apply filters similar to index method

        $orders = $query->paginate(20);

        return view('admin.orders.vendor', compact('orders'));
    }

    /**
     * Moderate orders view.
     */
    public function moderate(Request $request)
    {
        // Similar to index but with limited actions for moderators
        $query = Order::latest();

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.moderate', compact('orders'));
    }
}
