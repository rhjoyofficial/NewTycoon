@extends('frontend.layouts.app')

@section('title', 'Track Order')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Track Order</h1>
            <p class="text-gray-600 mt-1">Enter your order number and email to view order progress.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('orders.track') }}" class="grid md:grid-cols-3 gap-4">
                <input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="Order number" class="w-full rounded-lg border border-gray-300 px-4 py-2">
                <input type="email" name="email" value="{{ request('email') }}" placeholder="Order email" class="w-full rounded-lg border border-gray-300 px-4 py-2">
                <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-white hover:bg-primary-dark">Track</button>
            </form>
        </div>

        @if ($error)
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">{{ $error }}</div>
        @endif

        @if ($order)
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="text-lg font-semibold text-gray-900">{{ $order->order_number }}</div>
                        <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="text-sm">
                        <span class="rounded-full bg-gray-100 px-3 py-1 font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-600">
                    <div>Total: Tk {{ number_format($order->total_amount, 2) }}</div>
                    <div>Payment: {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</div>
                </div>

                <a href="{{ route('orders.tracking', ['order' => $order->id, 'email' => request('email'), 'access_token' => request('access_token')]) }}" class="inline-block mt-4 text-primary hover:underline">View full details</a>
            </div>
        @endif
    </div>
@endsection
