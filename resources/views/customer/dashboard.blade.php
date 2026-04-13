@extends('frontend.layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- ── Header ──────────────────────────────────────────────────────── --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user->name }} 👋</h1>
            <p class="text-gray-500 mt-1 text-sm">Here's a summary of your account activity.</p>
        </div>
        <a href="{{ route('profile') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fa-regular fa-user text-gray-500"></i> My Profile
        </a>
    </div>

    {{-- ── Flash ───────────────────────────────────────────────────────── --}}
    @if (session('status'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    {{-- ── Stats cards ─────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">Total Orders</span>
                <span class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-bag-shopping text-blue-500 text-sm"></i>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['total_orders'] }}</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">Total Spent</span>
                <span class="w-9 h-9 bg-green-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-bangladeshi-taka-sign text-green-500 text-sm"></i>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                <span class="font-bengali">৳</span>{{ number_format($stats['total_spent'], 0) }}
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">Pending</span>
                <span class="w-9 h-9 bg-yellow-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-clock text-yellow-500 text-sm"></i>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500">Completed</span>
                <span class="w-9 h-9 bg-purple-50 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-check text-purple-500 text-sm"></i>
                </span>
            </div>
            <div class="text-3xl font-bold text-gray-900">{{ $stats['completed'] }}</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- ── Recent orders ────────────────────────────────────────────── --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-900">Recent Orders</h2>
                    <a href="{{ route('account.orders') }}" class="text-sm text-primary hover:underline">View all</a>
                </div>

                @forelse ($recentOrders as $order)
                    <div class="px-5 py-4 border-b border-gray-100 last:border-b-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <span class="font-medium text-gray-900 text-sm">{{ $order->order_number }}</span>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y') }} · {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-semibold text-gray-800">
                                    <span class="font-bengali">৳</span>{{ number_format($order->total_amount, 0) }}
                                </span>
                                @php
                                    $statusColors = [
                                        'pending'    => 'bg-yellow-100 text-yellow-700',
                                        'processing' => 'bg-blue-100 text-blue-700',
                                        'on_hold'    => 'bg-orange-100 text-orange-700',
                                        'completed'  => 'bg-green-100 text-green-700',
                                        'cancelled'  => 'bg-red-100 text-red-700',
                                        'refunded'   => 'bg-purple-100 text-purple-700',
                                    ];
                                    $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                                <a href="{{ route('orders.show', $order) }}"
                                   class="text-xs text-primary hover:underline">View</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-sm text-gray-400">
                        <i class="fa-regular fa-bag-shopping text-2xl mb-2 block"></i>
                        No orders placed yet.
                        <a href="{{ route('products.index') }}" class="text-primary hover:underline ml-1">Start shopping</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ── Quick links ──────────────────────────────────────────────── --}}
        <div class="space-y-4">

            {{-- Account info card --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user text-primary"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile') }}"
                   class="block text-center text-sm text-primary border border-primary rounded-lg py-2 hover:bg-primary hover:text-white transition-colors">
                    Edit Profile
                </a>
            </div>

            {{-- Navigation links --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900 text-sm">Quick Links</h3>
                </div>
                <nav class="divide-y divide-gray-100">
                    <a href="{{ route('account.orders') }}"
                       class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-bag-shopping w-4 text-gray-400"></i> My Orders
                    </a>
                    <a href="{{ route('profile') }}#addresses"
                       class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-location-dot w-4 text-gray-400"></i> Saved Addresses
                    </a>
                    <a href="{{ route('profile') }}#password"
                       class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fa-solid fa-lock w-4 text-gray-400"></i> Change Password
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                            <i class="fa-solid fa-right-from-bracket w-4"></i> Sign Out
                        </button>
                    </form>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
