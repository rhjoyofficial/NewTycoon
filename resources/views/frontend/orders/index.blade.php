@extends('frontend.layouts.app')

@section('title', 'My Orders')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Orders</h1>
                <p class="text-gray-600 mt-1">Track your recent purchases and order status.</p>
            </div>
            <a href="{{ route('orders.track') }}" class="text-primary hover:underline">Track a guest order</a>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @forelse ($orders as $order)
                <div class="border-b border-gray-100 p-5 last:border-b-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <div class="font-semibold text-gray-900">{{ $order->order_number }}</div>
                            <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-gray-600">{{ $order->items_count }} items</div>
                            <div class="font-semibold text-gray-900">Tk {{ number_format($order->total_amount, 2) }}</div>
                            <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                            <a href="{{ route('orders.show', $order) }}" class="text-primary hover:underline">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">You have not placed any orders yet.</div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
