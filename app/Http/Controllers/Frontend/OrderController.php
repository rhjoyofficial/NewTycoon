<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorizeUserOrder($order);

        $order->load(['items.product', 'payment', 'transactions']);

        return view('frontend.orders.show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        $this->authorizeUserOrder($order);

        abort_unless(in_array($order->status, ['pending', 'processing', 'on_hold'], true), 422, 'This order can no longer be cancelled.');

        DB::transaction(fn () => $order->cancel('Cancelled by customer.'));

        return redirect()->route('orders.show', $order)->with('status', 'Order cancelled successfully.');
    }

    public function return(Order $order): RedirectResponse
    {
        $this->authorizeUserOrder($order);

        abort_unless($order->status === 'completed', 422, 'Only completed orders can be marked for return.');

        $metadata = $order->metadata ?? [];
        $metadata['return_request'] = [
            'requested_at' => now()->toDateTimeString(),
            'requested_by' => Auth::id(),
        ];

        $order->update([
            'metadata' => $metadata,
            'admin_note' => trim(($order->admin_note ? $order->admin_note . PHP_EOL : '') . 'Return requested by customer on ' . now()->format('Y-m-d H:i')),
        ]);

        return redirect()->route('orders.show', $order)->with('status', 'Return request submitted.');
    }

    public function track(Request $request): View
    {
        $order = null;

        if ($request->filled('order_number')) {
            $order = Order::where('order_number', $request->string('order_number'))->first();

            if (!$order || !$this->canAccessOrder($order, $request)) {
                return view('frontend.orders.track', [
                    'order' => null,
                    'error' => 'We could not find an order matching those details.',
                ]);
            }

            $order->load(['items.product', 'payment']);
        }

        return view('frontend.orders.track', [
            'order' => $order,
            'error' => null,
        ]);
    }

    public function tracking(Request $request, Order $order): View
    {
        abort_unless($this->canAccessOrder($order, $request), 404);

        $order->load(['items.product', 'payment']);

        return view('frontend.orders.show', compact('order'));
    }

    protected function authorizeUserOrder(Order $order): void
    {
        abort_unless(Auth::check() && $order->user_id === Auth::id(), 404);
    }

    protected function canAccessOrder(Order $order, Request $request): bool
    {
        if (Auth::check()) {
            return $order->user_id === Auth::id();
        }

        if ($order->canAccessAsGuest($request->string('access_token')->toString())) {
            return true;
        }

        return filled($request->email) && strcasecmp($order->customer_email, $request->string('email')->toString()) === 0;
    }
}
