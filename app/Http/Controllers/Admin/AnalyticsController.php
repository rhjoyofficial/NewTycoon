<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    /**
     * Display main analytics dashboard
     */
    public function index()
    {
        $stats = $this->getDashboardStats();
        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::with('category')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        $salesData = $this->getSalesData(30); // Last 30 days

        return view('admin.analytics.index', compact('stats', 'recentOrders', 'topProducts', 'salesData'));
    }

    /**
     * Display analytics dashboard (alias for index)
     */
    public function dashboard()
    {
        return $this->index();
    }

    /**
     * Display sales analytics
     */
    public function sales()
    {
        $period = request()->get('period', 'month');
        $dateRange = $this->getDateRange($period);

        $salesData = $this->getSalesData($period);
        $salesByStatus = $this->getSalesByStatus();
        $salesByPaymentMethod = $this->getSalesByPaymentMethod();
        $salesByCountry = $this->getSalesByCountry();

        return view('admin.analytics.sales', compact(
            'salesData',
            'salesByStatus',
            'salesByPaymentMethod',
            'salesByCountry',
            'period',
            'dateRange'
        ));
    }

    /**
     * Display revenue analytics
     */
    public function revenue()
    {
        $period = request()->get('period', 'month');
        $dateRange = $this->getDateRange($period);

        $revenueData = $this->getRevenueData($period);
        $revenueByCategory = $this->getRevenueByCategory();
        $revenueByProduct = $this->getRevenueByProduct();
        $averageOrderValue = $this->getAverageOrderValue();

        return view('admin.analytics.revenue', compact(
            'revenueData',
            'revenueByCategory',
            'revenueByProduct',
            'averageOrderValue',
            'period',
            'dateRange'
        ));
    }

    /**
     * Display customer analytics
     */
    public function customers()
    {
        $period = request()->get('period', 'month');
        $dateRange = $this->getDateRange($period);

        $customerStats = $this->getCustomerStats();
        $newCustomers = $this->getNewCustomers($period);
        $customerAcquisition = $this->getCustomerAcquisitionData($period);
        $topCustomers = $this->getTopCustomers();

        return view('admin.analytics.customers', compact(
            'customerStats',
            'newCustomers',
            'customerAcquisition',
            'topCustomers',
            'period',
            'dateRange'
        ));
    }

    /**
     * Display product analytics
     */
    public function products()
    {
        $topSellingProducts = Product::with('category', 'brand')
            ->orderBy('total_sold', 'desc')
            ->take(20)
            ->get();

        $lowStockProducts = Product::where('track_quantity', true)
            ->where('quantity', '<=', DB::raw('alert_quantity'))
            ->where('quantity', '>', 0)
            ->orderBy('quantity')
            ->take(20)
            ->get();

        $outOfStockProducts = Product::where('track_quantity', true)
            ->where('quantity', '<=', 0)
            ->where('allow_backorder', false)
            ->orderBy('name')
            ->take(20)
            ->get();

        $bestPerformingCategories = $this->getBestPerformingCategories();

        return view('admin.analytics.products', compact(
            'topSellingProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'bestPerformingCategories'
        ));
    }

    /**
     * Display order analytics
     */
    public function orders()
    {
        $period = request()->get('period', 'month');
        $dateRange = $this->getDateRange($period);

        $orderStats = $this->getOrderStats();
        $ordersByStatus = $this->getOrdersByStatus();
        $ordersByDay = $this->getOrdersByDay($period);
        $averageProcessingTime = $this->getAverageProcessingTime();

        return view('admin.analytics.orders', compact(
            'orderStats',
            'ordersByStatus',
            'ordersByDay',
            'averageProcessingTime',
            'period',
            'dateRange'
        ));
    }

    /**
     * Sales report
     */
    public function salesReport()
    {
        $startDate = request()->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = request()->get('end_date', Carbon::now()->format('Y-m-d'));

        $sales = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'completed')
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $summary = $this->getSalesSummary($startDate, $endDate);

        return view('admin.analytics.reports.sales', compact('sales', 'summary', 'startDate', 'endDate'));
    }

    /**
     * Customers report
     */
    public function customersReport()
    {
        $customers = User::role('customer')
            ->with(['orders' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withCount(['orders' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.analytics.reports.customers', compact('customers'));
    }

    /**
     * Products report
     */
    public function productsReport()
    {
        $products = Product::with(['category', 'brand'])
            ->withCount(['orderItems as total_orders'])
            ->orderBy('total_sold', 'desc')
            ->paginate(50);

        return view('admin.analytics.reports.products', compact('products'));
    }

    /**
     * Export analytics data
     */
    public function export($type)
    {
        // Implementation for exporting data
        // This would generate CSV/Excel files based on $type
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    /**
     * Get sales over time data for charts
     */
    public function salesOverTime()
    {
        $period = request()->get('period', 'month');
        $data = $this->getSalesData($period, true);

        return response()->json($data);
    }

    /**
     * Get top products data
     */
    public function topProducts()
    {
        $limit = request()->get('limit', 10);
        $products = Product::orderBy('total_sold', 'desc')
            ->take($limit)
            ->get(['name', 'total_sold', 'total_revenue']);

        return response()->json($products);
    }

    /**
     * Get top categories data
     */
    public function topCategories()
    {
        $limit = request()->get('limit', 10);
        $categories = Category::withCount(['products'])
            ->withSum(['products' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(total_sold), 0)'));
            }], 'total_sold')
            ->orderBy('products_sum_total_sold', 'desc')
            ->take($limit)
            ->get();

        return response()->json($categories);
    }

    /**
     * Get top customers data
     */
    public function topCustomers()
    {
        $limit = request()->get('limit', 10);
        $customers = User::role('customer')
            ->withCount(['orders' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['orders' => function ($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take($limit)
            ->get(['name', 'email', 'orders_count', 'orders_sum_total_amount']);

        return response()->json($customers);
    }

    /**
     * Private helper methods
     */

    private function getDashboardStats()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            // Today
            'today' => [
                'orders' => Order::whereDate('created_at', $today)->count(),
                'revenue' => Order::whereDate('created_at', $today)->where('status', 'completed')->sum('total_amount'),
                'customers' => User::whereDate('created_at', $today)->role('customer')->count(),
                'products_sold' => DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->whereDate('orders.created_at', $today)
                    ->where('orders.status', 'completed')
                    ->sum('quantity'),
            ],

            // Yesterday
            'yesterday' => [
                'orders' => Order::whereDate('created_at', $yesterday)->count(),
                'revenue' => Order::whereDate('created_at', $yesterday)->where('status', 'completed')->sum('total_amount'),
                'customers' => User::whereDate('created_at', $yesterday)->role('customer')->count(),
                'products_sold' => DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->whereDate('orders.created_at', $yesterday)
                    ->where('orders.status', 'completed')
                    ->sum('quantity'),
            ],

            // This Month
            'this_month' => [
                'orders' => Order::where('created_at', '>=', $thisMonth)->count(),
                'revenue' => Order::where('created_at', '>=', $thisMonth)->where('status', 'completed')->sum('total_amount'),
                'customers' => User::where('created_at', '>=', $thisMonth)->role('customer')->count(),
                'products_sold' => DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.created_at', '>=', $thisMonth)
                    ->where('orders.status', 'completed')
                    ->sum('quantity'),
            ],

            // Last Month
            'last_month' => [
                'orders' => Order::whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
                'revenue' => Order::whereBetween('created_at', [$lastMonth, $thisMonth])->where('status', 'completed')->sum('total_amount'),
                'customers' => User::whereBetween('created_at', [$lastMonth, $thisMonth])->role('customer')->count(),
                'products_sold' => DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->whereBetween('orders.created_at', [$lastMonth, $thisMonth])
                    ->where('orders.status', 'completed')
                    ->sum('quantity'),
            ],

            // Totals
            'totals' => [
                'orders' => Order::count(),
                'revenue' => Order::where('status', 'completed')->sum('total_amount'),
                'customers' => User::role('customer')->count(),
                'products' => Product::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
                'processing_orders' => Order::where('status', 'processing')->count(),
            ],
        ];
    }

    private function getSalesData($period, $forChart = false)
    {
        $startDate = $this->getStartDate($period);

        $sales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as orders_count'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN total_amount ELSE 0 END) as revenue'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_orders')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        if ($forChart) {
            return [
                'labels' => $sales->pluck('date'),
                'orders' => $sales->pluck('orders_count'),
                'revenue' => $sales->pluck('revenue'),
            ];
        }

        return $sales;
    }

    private function getSalesByStatus()
    {
        return Order::select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as revenue'))
            ->groupBy('status')
            ->get();
    }

    private function getSalesByPaymentMethod()
    {
        return Order::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as revenue'))
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->get();
    }

    private function getSalesByCountry()
    {
        return Order::select('shipping_country as country', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as revenue'))
            ->where('status', 'completed')
            ->groupBy('shipping_country')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();
    }

    private function getRevenueData($period)
    {
        $startDate = $this->getStartDate($period);

        return Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as revenue'),
            DB::raw('AVG(total_amount) as avg_order_value'),
            DB::raw('COUNT(*) as orders_count')
        )
            ->where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getRevenueByCategory()
    {
        return Category::withSum(['products' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(total_revenue), 0)'));
        }], 'total_revenue')
            ->orderBy('products_sum_total_revenue', 'desc')
            ->take(10)
            ->get();
    }

    private function getRevenueByProduct()
    {
        return Product::select('name', 'total_revenue', 'total_sold')
            ->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get();
    }

    private function getAverageOrderValue()
    {
        $avg = Order::where('status', 'completed')
            ->select(DB::raw('AVG(total_amount) as avg_value'))
            ->first();

        return $avg ? $avg->avg_value : 0;
    }

    private function getCustomerStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'total' => User::role('customer')->count(),
            'new_today' => User::whereDate('created_at', $today)->role('customer')->count(),
            'new_this_month' => User::where('created_at', '>=', $thisMonth)->role('customer')->count(),
            'new_last_month' => User::whereBetween('created_at', [$lastMonth, $thisMonth])->role('customer')->count(),
            'active_today' => Order::whereDate('created_at', $today)
                ->where('status', 'completed')
                ->distinct('user_id')
                ->count('user_id'),
            'avg_order_frequency' => $this->calculateAverageOrderFrequency(),
        ];
    }

    private function getNewCustomers($period)
    {
        $startDate = $this->getStartDate($period);

        return User::role('customer')
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
    }

    private function getCustomerAcquisitionData($period)
    {
        $startDate = $this->getStartDate($period);

        return User::role('customer')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as new_customers')
            )
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getTopCustomers()
    {
        return User::role('customer')
            ->withCount(['orders' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['orders' => function ($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(10)
            ->get();
    }

    private function getBestPerformingCategories()
    {
        return Category::withCount(['products'])
            ->withSum(['products' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(total_sold), 0)'));
            }], 'total_sold')
            ->withSum(['products' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(total_revenue), 0)'));
            }], 'total_revenue')
            ->orderBy('products_sum_total_revenue', 'desc')
            ->take(10)
            ->get();
    }

    private function getOrderStats()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total' => Order::count(),
            'completed' => Order::where('status', 'completed')->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'today' => Order::whereDate('created_at', $today)->count(),
            'this_month' => Order::where('created_at', '>=', $thisMonth)->count(),
            'avg_value' => $this->getAverageOrderValue(),
        ];
    }

    private function getOrdersByStatus()
    {
        return Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
    }

    private function getOrdersByDay($period)
    {
        $startDate = $this->getStartDate($period);

        return Order::select(
            DB::raw('DAYNAME(created_at) as day'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('day')
            ->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
            ->get();
    }

    private function getAverageProcessingTime()
    {
        $result = Order::whereNotNull('processing_at')
            ->whereNotNull('shipped_at')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(HOUR, processing_at, shipped_at)) as avg_hours')
            )
            ->first();

        return $result ? $result->avg_hours : 0;
    }

    private function getSalesSummary($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'completed')
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw('AVG(total_amount) as avg_order_value'),
                DB::raw('SUM(shipping_cost) as total_shipping'),
                DB::raw('SUM(tax_amount) as total_tax'),
                DB::raw('SUM(discount_amount) as total_discount')
            )
            ->first();
    }

    private function calculateAverageOrderFrequency()
    {
        $customersWithOrders = User::role('customer')
            ->has('orders', '>', 1)
            ->withCount('orders')
            ->get();

        if ($customersWithOrders->isEmpty()) {
            return 0;
        }

        $totalOrders = $customersWithOrders->sum('orders_count');
        $totalCustomers = $customersWithOrders->count();

        return $totalCustomers > 0 ? $totalOrders / $totalCustomers : 0;
    }

    private function getStartDate($period)
    {
        switch ($period) {
            case 'week':
                return Carbon::now()->subDays(7);
            case 'month':
                return Carbon::now()->subDays(30);
            case 'quarter':
                return Carbon::now()->subDays(90);
            case 'year':
                return Carbon::now()->subDays(365);
            default:
                return Carbon::now()->subDays(30);
        }
    }

    private function getDateRange($period)
    {
        $startDate = $this->getStartDate($period);

        return [
            'start' => $startDate->format('Y-m-d'),
            'end' => Carbon::now()->format('Y-m-d'),
        ];
    }

    /**
     * Get average time from order to processing
     */
    private function getAverageTimeToProcessing()
    {
        $result = Order::whereNotNull('processing_at')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, processing_at)) as avg_hours')
            )
            ->first();

        if ($result && $result->avg_hours) {
            if ($result->avg_hours < 24) {
                return number_format($result->avg_hours, 1) . ' hours';
            } else {
                return number_format($result->avg_hours / 24, 1) . ' days';
            }
        }

        return 'N/A';
    }

    /**
     * Get average shipping time
     */
    private function getAverageShippingTime()
    {
        $result = Order::whereNotNull('shipped_at')
            ->whereNotNull('delivered_at')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(DAY, shipped_at, delivered_at)) as avg_days')
            )
            ->first();

        if ($result && $result->avg_days) {
            return number_format($result->avg_days, 1) . ' days';
        }

        return 'N/A';
    }

    /**
     * Get average order cycle time
     */
    private function getAverageOrderCycleTime()
    {
        $result = Order::whereNotNull('delivered_at')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(DAY, created_at, delivered_at)) as avg_days')
            )
            ->first();

        if ($result && $result->avg_days) {
            return number_format($result->avg_days, 1) . ' days';
        }

        return 'N/A';
    }

    /**
     * Get average cancellation time
     */
    private function getAverageCancellationTime()
    {
        $result = Order::where('status', 'cancelled')
            ->whereNotNull('cancelled_at')
            ->select(
                DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, cancelled_at)) as avg_hours')
            )
            ->first();

        if ($result && $result->avg_hours) {
            if ($result->avg_hours < 24) {
                return number_format($result->avg_hours, 1) . ' hours';
            } else {
                return number_format($result->avg_hours / 24, 1) . ' days';
            }
        }

        return 'N/A';
    }

    /**
     * Get average profit margin
     */
    public function getAverageProfitMargin()
    {
        $products = Product::where('cost_price', '>', 0)
            ->where('price', '>', 0)
            ->get();

        if ($products->isEmpty()) {
            return 0;
        }

        $totalMargin = 0;
        $count = 0;

        foreach ($products as $product) {
            if ($product->price > 0) {
                $margin = (($product->price - $product->cost_price) / $product->price) * 100;
                $totalMargin += $margin;
                $count++;
            }
        }

        return $count > 0 ? number_format($totalMargin / $count, 1) : 0;
    }

    /**
     * Get average selling price
     */
    public function getAverageSellingPrice()
    {
        $avg = Product::where('status', 'active')
            ->avg('price');

        return $avg ?: 0;
    }
}
