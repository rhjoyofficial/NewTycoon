<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class CheckoutService
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function checkoutCart(Cart $cart, array $validated, Request $request): Order
    {
        if ($cart->items->isEmpty()) {
            throw new RuntimeException('Your cart is empty.');
        }

        $lineItems = $cart->items
            ->map(fn($item) => [
                'product_id' => $item->product_id,
                'quantity' => (int) $item->quantity,
            ])
            ->values()
            ->all();

        return DB::transaction(function () use ($cart, $validated, $request, $lineItems) {
            $order = $this->createOrderFromLineItems($lineItems, $validated, $request);
            $cart->items()->delete();

            return $order;
        });
    }

    public function checkoutBuyNow(array $buyNowData, array $validated, Request $request): Order
    {
        $lineItems = [[
            'product_id' => (int) $buyNowData['product_id'],
            'quantity' => (int) $buyNowData['quantity'],
        ]];

        return DB::transaction(fn() => $this->createOrderFromLineItems($lineItems, $validated, $request));
    }

    protected function createOrderFromLineItems(array $lineItems, array $validated, Request $request): Order
    {
        $user = $this->resolveCheckoutUser($validated, $request);
        $products = $this->lockProducts($lineItems);
        $pricingLines = $this->buildPricingLines($lineItems, $products);
        $subtotal = round(collect($pricingLines)->sum('line_total'), 2);
        $shippingCost = 0.0;
        $discountAmount = 0.0;
        $taxAmount = 0.0;
        $total = round($subtotal + $shippingCost + $taxAmount - $discountAmount, 2);

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $user?->id,
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'shipping_name' => $validated['name'],
            'shipping_email' => $validated['email'],
            'shipping_phone' => $validated['phone'],
            'shipping_address_line1' => $validated['address'],
            'shipping_address_line2' => null,
            'shipping_city' => $validated['city'],
            'shipping_state' => 'Dhaka',
            'shipping_country' => 'Bangladesh',
            'shipping_zip_code' => $validated['postal_code'],
            'billing_same_as_shipping' => true,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $total,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'shipping_method' => 'standard',
            'status' => 'pending',
            'customer_note' => $validated['notes'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if (!$user) {
            $plainToken = Str::random(40);
            $order->forceFill([
                'guest_access_token_hash' => hash('sha256', $plainToken),
            ])->save();
            $order->guest_access_token = $plainToken;
        }

        foreach ($pricingLines as $line) {
            /** @var Product $product */
            $product = $line['product'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku ?? 'N/A',
                'product_image' => is_array($product->featured_images) && !empty($product->featured_images)
                    ? $product->featured_images[0]
                    : null,
                'quantity' => $line['quantity'],
                'unit_price' => $line['unit_price'],
                'total_price' => $line['line_total'],
                'discount_amount' => 0,
                'tax_amount' => 0,
            ]);

            $product->reserveStock($line['quantity']);
            $product->recordSale($line['quantity'], $line['unit_price']);
        }

        $this->paymentService->createPendingPayment($order, $validated['payment_method']);

        return $order->fresh(['items.product', 'payment']);
    }

    protected function resolveCheckoutUser(array $validated, Request $request): ?User
    {
        $user = Auth::user();

        if ($user || !$request->boolean('create_account')) {
            return $user;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        $user->assignRole('customer');

        Address::create([
            'user_id' => $user->id,
            'type' => 'shipping',
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address_line_1' => $validated['address'],
            'address_line_2' => null,
            'city' => $validated['city'],
            'state' => 'Dhaka',
            'postal_code' => $validated['postal_code'],
            'country' => 'Bangladesh',
            'is_default' => true,
        ]);

        Auth::login($user);

        return $user;
    }

    protected function lockProducts(array $lineItems)
    {
        $productIds = collect($lineItems)->pluck('product_id')->unique()->values();

        return Product::query()
            ->whereIn('id', $productIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }

    protected function buildPricingLines(array $lineItems, $products): array
    {
        return collect($lineItems)->map(function (array $lineItem) use ($products) {
            /** @var Product|null $product */
            $product = $products->get($lineItem['product_id']);

            if (!$product || !$product->is_active) {
                throw new RuntimeException('One of the selected products is no longer available.');
            }

            $quantity = (int) $lineItem['quantity'];
            $product->ensureCanFulfill($quantity);

            $unitPrice = round((float) $product->price, 2);

            return [
                'product' => $product,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => round($quantity * $unitPrice, 2),
            ];
        })->all();
    }
}
