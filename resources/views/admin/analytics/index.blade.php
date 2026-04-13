@extends('admin.layouts.app')

@section('title', 'Analytics Dashboard')
@section('page-title', 'Analytics Dashboard')

@section('breadcrumb')
    <li class="inline-flex items-center">
        <svg class="h-5 w-5 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
        </svg>
        <span class="text-gray-700">Analytics</span>
    </li>
@endsection

@section('content')
    <div class="max-w-8xl mx-auto">
        <div class="space-y-6">
            <!-- Period Selector -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Analytics Period</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.analytics.index', ['period' => 'week']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ request('period') == 'week' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 7 Days
                        </a>
                        <a href="{{ route('admin.analytics.index', ['period' => 'month']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ !request('period') || request('period') == 'month' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 30 Days
                        </a>
                        <a href="{{ route('admin.analytics.index', ['period' => 'quarter']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ request('period') == 'quarter' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last 90 Days
                        </a>
                        <a href="{{ route('admin.analytics.index', ['period' => 'year']) }}"
                            class="px-3 py-1.5 text-sm font-medium rounded-lg {{ request('period') == 'year' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Last Year
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Today -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Today</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2 font-bengali">
                                ৳{{ number_format($stats['today']['revenue'], 2) }}
                            </p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Orders</span>
                            <span class="font-medium">{{ $stats['today']['orders'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Customers</span>
                            <span class="font-medium">{{ $stats['today']['customers'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Products Sold</span>
                            <span class="font-medium">{{ $stats['today']['products_sold'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- This Month -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">This Month</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2 font-bengali">
                                ৳{{ number_format($stats['this_month']['revenue'], 2) }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Orders</span>
                            <span class="font-medium">{{ $stats['this_month']['orders'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">New Customers</span>
                            <span class="font-medium">{{ $stats['this_month']['customers'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Products Sold</span>
                            <span class="font-medium">{{ $stats['this_month']['products_sold'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2 font-bengali">
                                ৳{{ number_format($stats['totals']['revenue'], 2) }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <svg class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Orders</span>
                            <span class="font-medium">{{ $stats['totals']['orders'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Customers</span>
                            <span class="font-medium">{{ $stats['totals']['customers'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Products</span>
                            <span class="font-medium">{{ $stats['totals']['products'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Orders</p>
                            <p class="text-2xl font-bold text-gray-800 mt-2">
                                {{ $stats['totals']['pending_orders'] + $stats['totals']['processing_orders'] }}</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-lg">
                            <svg class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Pending</span>
                            <span class="font-medium">{{ $stats['totals']['pending_orders'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Processing</span>
                            <span class="font-medium">{{ $stats['totals']['processing_orders'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Completion Rate</span>
                            <span
                                class="font-medium">{{ $stats['totals']['orders'] > 0 ? round((($stats['totals']['orders'] - $stats['totals']['pending_orders'] - $stats['totals']['processing_orders']) / $stats['totals']['orders']) * 100, 1) : 0 }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts and Data -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Sales Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Sales Overview</h3>
                        <div class="flex space-x-2" id="chart-filters">
                            <button onclick="updateChart('week', event)"
                                class="text-xs px-2 py-1 rounded bg-gray-100 hover:bg-gray-200">7D</button>
                            <button onclick="updateChart('month', event)"
                                class="text-xs px-2 py-1 rounded bg-gray-100 hover:bg-gray-200">30D</button>
                            <button onclick="updateChart('quarter', event)"
                                class="text-xs px-2 py-1 rounded bg-gray-100 hover:bg-gray-200">90D</button>
                        </div>
                    </div>
                    <div class="flex-1 min-h-0">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
                        <a href="{{ route('admin.orders.index') }}"
                            class="text-sm text-primary hover:text-primary-dark font-medium">View All</a>
                    </div>
                    <div class="max-h-[21rem] overflow-y-auto">
                        <div class="space-y-4 pr-2">
                            @foreach ($recentOrders as $order)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div>
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="font-medium text-gray-800 hover:text-primary">{{ $order->order_number }}</a>
                                        <p class="text-sm text-gray-500">{{ $order->customer_name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-800 font-bengali">
                                            ৳{{ number_format($order->total_amount, 2) }}
                                        </p>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_badge_color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Top Selling Products</h3>
                    <a href="{{ route('admin.analytics.products') }}"
                        class="text-sm text-primary hover:text-primary-dark font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sold</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Revenue</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($topProducts as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-lg object-cover"
                                                    src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ Str::limit($product->name, 30) }}</div>
                                                <div class="text-sm text-gray-500">{{ $product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->total_sold }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-bengali">
                                        ৳{{ number_format($product->total_revenue, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($product->track_quantity)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->quantity <= $product->alert_quantity ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $product->quantity }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Unlimited
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let salesChart;

        function initChart() {
            const ctx = document.getElementById('salesChart').getContext('2d');

            const data = {
                labels: @json($salesData->pluck('date')),
                datasets: [{
                        label: 'Revenue',
                        data: @json($salesData->pluck('revenue')),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        yAxisID: 'y',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Orders',
                        data: @json($salesData->pluck('orders_count')),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        yAxisID: 'y1',
                        fill: true,
                        tension: 0.4
                    }
                ]
            };

            salesChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Revenue ($)'
                            },
                            grid: {
                                drawBorder: false
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Orders'
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        }

        async function updateChart(period, event) {
            try {
                const response = await fetch(`{{ route('admin.analytics.data.salesOverTime') }}?period=${period}`);
                const data = await response.json();

                salesChart.data.labels = data.labels;
                salesChart.data.datasets[0].data = data.revenue;
                salesChart.data.datasets[1].data = data.orders;
                salesChart.update();

                // --- Update active button UI ---
                const container = document.getElementById('chart-filters');
                const buttons = container.querySelectorAll('button');

                buttons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                });

                // Set the clicked button to active
                const clickedBtn = event.currentTarget;
                clickedBtn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                clickedBtn.classList.add('bg-primary', 'text-white');


            } catch (error) {
                console.error('Error updating chart:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initChart();
        });
    </script>
@endpush
