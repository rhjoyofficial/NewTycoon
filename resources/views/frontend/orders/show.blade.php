@extends('frontend.layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
                <p class="text-gray-600 mt-1">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <a href="{{ Auth::check() ? route('account.orders') : route('orders.track') }}" class="text-primary hover:underline">Back</a>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Items</h2>
                </div>
                @foreach ($order->items as $item)
                    <div class="px-5 py-4 border-b border-gray-100 last:border-b-0 flex items-center justify-between gap-4">
                        <div>
                            <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                            <div class="text-sm text-gray-500">Qty: {{ $item->quantity }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-semibold text-gray-900">Tk {{ number_format($item->total_price, 2) }}</div>
                            <div class="text-sm text-gray-500">Tk {{ number_format($item->unit_price, 2) }} each</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="font-semibold text-gray-900 mb-4">Summary</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-600">Status</span><span>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-600">Payment</span><span>{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-600">Subtotal</span><span>Tk {{ number_format($order->subtotal, 2) }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-600">Shipping</span><span>Tk {{ number_format($order->shipping_cost, 2) }}</span></div>
                        <div class="flex justify-between font-semibold text-gray-900 border-t border-gray-100 pt-2"><span>Total</span><span>Tk {{ number_format($order->total_amount, 2) }}</span></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="font-semibold text-gray-900 mb-4">Shipping</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div>{{ $order->shipping_name }}</div>
                        <div>{{ $order->shipping_phone }}</div>
                        <div>{{ $order->shipping_address }}</div>
                    </div>
                </div>

                @auth
                    <div class="bg-white rounded-xl border border-gray-200 p-5 space-y-3">
                        @if (in_array($order->status, ['pending', 'processing', 'on_hold'], true))
                            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                @csrf
                                <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">Cancel Order</button>
                            </form>
                        @endif

                        @if ($order->status === 'completed')
                            <form method="POST" action="{{ route('orders.return', $order) }}">
                                @csrf
                                <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2 text-white hover:bg-black">Request Return</button>
                            </form>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
