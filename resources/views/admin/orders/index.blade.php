@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page-title', 'Order Management')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Orders</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
                        <p class="text-gray-600 mt-1">Manage customer orders and fulfillment</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.orders.create') }}"
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-primary to-primary/80 hover:from-primary/90 hover:to-primary/70 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Order
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Orders</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Completed</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Processing</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['processing'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-xl p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 rounded-lg">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Cancelled</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['cancelled'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <form method="GET" class="space-y-4" data-form>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Order #, Customer, Email"
                                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Processing
                                </option>
                                <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>On Hold
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                                <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded
                                </option>
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                            <select name="payment_status"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <option value="">All Payments</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>
                                    Failed
                                </option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>
                                    Refunded</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                            <select name="date_range"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today
                                </option>
                                <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>
                                    Yesterday</option>
                                <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>
                                    This
                                    Week</option>
                                <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>
                                    This
                                    Month</option>
                                <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>
                                    Last
                                    Month</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit" data-loading data-loading-text="Filtering..."
                            class="px-4 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl hover:shadow-md transition-all">
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                            class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                        class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 hover:bg-yellow-100 transition-colors">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Pending Orders</p>
                                <p class="text-sm text-gray-600">{{ $stats['pending'] }} orders</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                        class="bg-blue-50 border border-blue-200 rounded-xl p-4 hover:bg-blue-100 transition-colors">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Processing</p>
                                <p class="text-sm text-gray-600">{{ $stats['processing'] }} orders</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders.index', ['payment_status' => 'pending']) }}"
                        class="bg-orange-50 border border-orange-200 rounded-xl p-4 hover:bg-orange-100 transition-colors">
                        <div class="flex items-center">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Pending Payments</p>
                                <p class="text-sm text-gray-600">{{ $pendingPayments }} orders</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders.index', ['date_range' => 'today']) }}"
                        class="bg-green-50 border border-green-200 rounded-xl p-4 hover:bg-green-100 transition-colors">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Today's Orders</p>
                                <p class="text-sm text-gray-600">{{ $todayOrders }} orders</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Order
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Payment
                                </th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                    class="hover:text-primary">
                                                    {{ $order->order_number }}
                                                </a>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $order->total_items }} item{{ $order->total_items != 1 ? 's' : '' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $order->customer_email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">
                                            <span
                                                class="font-bengali">৳</span>{{ number_format($order->total_amount, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->status_badge_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->payment_status_badge_color }} mr-2">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                            @if ($order->payment_method)
                                                <span class="text-xs text-gray-500">{{ $order->payment_method }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                                class="p-2 text-gray-400 hover:text-primary hover:bg-gray-100 rounded-lg transition-colors"
                                                title="View Order">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.orders.edit', $order) }}"
                                                class="p-2 text-gray-400 hover:text-primary hover:bg-gray-100 rounded-lg transition-colors"
                                                title="Edit Order">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open"
                                                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                                                    title="More Actions">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                    </svg>
                                                </button>

                                                <div x-show="open" @click.away="open = false"
                                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 z-10">
                                                    <div class="py-1">
                                                        @if ($order->status === 'pending')
                                                            <form
                                                                action="{{ route('admin.orders.update.status', $order) }}"
                                                                method="POST" class="block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="processing">
                                                                <button type="submit"
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    Mark as Processing
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($order->status === 'processing')
                                                            <form
                                                                action="{{ route('admin.orders.update.status', $order) }}"
                                                                method="POST" class="block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="completed">
                                                                <button type="submit"
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    Mark as Completed
                                                                </button>
                                                            </form>
                                                        @endif

                                                        @if ($order->payment_status === 'pending')
                                                            <form
                                                                action="{{ route('admin.orders.update.payment', $order) }}"
                                                                method="POST" class="block">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="payment_status"
                                                                    value="paid">
                                                                <button type="submit"
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                    Mark as Paid
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <a href="{{ route('admin.orders.invoice', $order) }}"
                                                            target="_blank"
                                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            Print Invoice
                                                        </a>

                                                        @if ($order->status !== 'cancelled')
                                                            <form action="{{ route('admin.orders.cancel', $order) }}"
                                                                method="POST" class="block">
                                                                @csrf
                                                                @method('POST')
                                                                <button type="submit"
                                                                    onclick="return confirm('Are you sure you want to cancel this order?')"
                                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                                    Cancel Order
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-16 w-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                                            <p class="text-gray-600 mb-6">When you receive orders, they will appear here
                                            </p>
                                            <a href="{{ route('admin.orders.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-primary/80 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-200">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Create Order
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-refresh page every 60 seconds for new orders
        setInterval(function() {
            if (!document.hidden) {
                window.location.reload();
            }
        }, 60000);

        // Export orders
        document.getElementById('exportOrders')?.addEventListener('click', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('export', 'true');
            window.location.href = '{{ route('admin.orders.index') }}?' + params.toString();
        });
    </script>
@endpush
