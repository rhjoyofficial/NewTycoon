<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Product\ActiveProductService;

class ProductController extends Controller
{
    public function __construct(
        protected ActiveProductService $productService
    ) {}

    /**
     * Display a listing of products with filters
     */
    public function index(Request $request)
    {
        $query = Product::query()->with(['category:id,name_en,name_bn,slug,parent_id']);

        $products = $this->getFilteredProductsQuery($request, $query)->paginate($request->get('per_page', 20));

        $categories = $this->getCategoryFilterData();
        $priceRange = $this->getGlobalPriceRange();

        return view('frontend.products.index', array_merge(
            compact('products', 'categories', 'priceRange'),
            $this->getFilterParameters($request)
        ));
    }

    /**
     * Display featured products
     */
    public function featured(Request $request)
    {
        $query = Product::query()
            ->with(['category:id,name_en,name_bn,slug,parent_id'])
            ->featured();  // scope from Product model

        $products = $this->getFilteredProductsQuery($request, $query)->paginate($request->get('per_page', 20));

        $categories = $this->getCategoryFilterData();
        $priceRange = $this->getGlobalPriceRange();

        return view('frontend.products.index', array_merge(
            compact('products', 'categories', 'priceRange'),
            $this->getFilterParameters($request),
            [
                'title'       => 'Featured Products',
                'description' => 'Explore our hand-picked featured products'
            ]
        ));
    }

    /**
     * Display new arrivals
     */
    public function newArrivals(Request $request)
    {
        $query = Product::query()
            ->with(['category:id,name_en,name_bn,slug,parent_id'])
            ->new();  // scope from Product model

        $products = $this->getFilteredProductsQuery($request, $query)->paginate($request->get('per_page', 20));

        $categories = $this->getCategoryFilterData();
        $priceRange = $this->getGlobalPriceRange();

        return view('frontend.products.index', array_merge(
            compact('products', 'categories', 'priceRange'),
            $this->getFilterParameters($request),
            [
                'title'       => 'New Arrivals',
                'description' => 'Discover our latest products'
            ]
        ));
    }

    /**
     * Display best selling products
     */
    public function bestSelling(Request $request)
    {
        $query = Product::query()
            ->with(['category:id,name_en,name_bn,slug,parent_id'])
            ->where(function ($q) {
                $q->where('is_bestsells', true)
                    ->orWhere('average_rating', '>=', 4.2)
                    ->orWhere('total_sold', '>', 50);
            })
            ->orderByDesc('average_rating')
            ->orderByDesc('total_sold');

        $products = $this->getFilteredProductsQuery($request, $query, $skipSorting = true)
            ->paginate($request->get('per_page', 20));

        $categories = $this->getCategoryFilterData();
        $priceRange = $this->getGlobalPriceRange();

        return view('frontend.products.index', array_merge(
            compact('products', 'categories', 'priceRange'),
            $this->getFilterParameters($request),
            [
                'title'       => 'Best Selling',
                'description' => 'Our most popular products'
            ]
        ));
    }

    /**
     * Display recommended products
     */
    public function recommended(Request $request)
    {
        $query = Product::query()
            ->with(['category:id,name_en,name_bn,slug,parent_id'])
            ->inStock()
            ->orderByDesc('total_sold')
            ->orderByDesc('average_rating');

        $products = $this->getFilteredProductsQuery($request, $query, $skipSorting = true)
            ->paginate($request->get('per_page', 20));

        $categories = $this->getCategoryFilterData();
        $priceRange = $this->getGlobalPriceRange();

        return view('frontend.products.index', array_merge(
            compact('products', 'categories', 'priceRange'),
            $this->getFilterParameters($request),
            [
                'title'       => 'Recommended for You',
                'description' => 'Products we think you will love'
            ]
        ));
    }

    public function offers(Request $request)
    {
        $query = Product::query()
            ->with(['category:id,name_en,name_bn,slug,parent_id'])
            ->featured(); 

        $products = $this->getFilteredProductsQuery($request, $query)->paginate($request->get('per_page', 20));

        $categories = $this->getCategoryFilterData();
        $priceRange = $this->getGlobalPriceRange();

        return view('frontend.products.index', array_merge(
            compact('products', 'categories', 'priceRange'),
            $this->getFilterParameters($request),
            [
                'title'       => 'Offer Products',
                'description' => 'Check out our special offer products'
            ]
        ));
    }

    /**
     * Apply all filters (search, category, price, status, sort) to a query.
     */
    protected function getFilteredProductsQuery(Request $request, $baseQuery = null, $skipSorting = false)
    {
        $query = $baseQuery ?: Product::query();
        $query->active()->withActiveCategory();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                    ->orWhere('name_bn', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('model_number', 'like', "%{$search}%")
                    ->orWhere('short_description_en', 'like', "%{$search}%")
                    ->orWhere('short_description_bn', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category = $request->get('category')) {
            $categoryModel = Category::where('id', $category)
                ->orWhere('slug', $category)
                ->first();
            if ($categoryModel) {
                $query->whereIn('category_id', $categoryModel->getAllCategoryIds());
            }
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Status filter (overrides the base scope if needed)
        if ($status = $request->get('status')) {
            switch ($status) {
                case 'in_stock':
                    $query->inStock();
                    break;
                case 'out_of_stock':
                    $query->where('stock_status', 'out_of_stock');
                    break;
                case 'new':
                    $query->where('is_new', true);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'discounted':
                    $query->where('discount_percentage', '>', 0);
                    break;
                case 'bestseller':
                    $query->where('is_bestsells', true);
                    break;
            }
        }

        // Sorting (skip if the base query already has custom ordering)
        if (!$skipSorting) {
            $this->applySorting($query, $request->get('sort', 'latest'));
        }

        return $query;
    }

    /**
     * Get categories with product counts for filter sidebar.
     */
    protected function getCategoryFilterData()
    {
        return Category::active()
            ->leaf()
            ->select('id', 'name_en', 'name_bn', 'slug', 'parent_id', 'depth')
            ->with('parent:id,name_en,name_bn')
            ->withCount(['products' => function ($query) {
                $query->active()->withActiveCategory();
            }])
            ->having('products_count', '>', 0)
            ->orderBy('name_en')
            ->get();
    }

    /**
     * Get global min/max price from all active products.
     */
    protected function getGlobalPriceRange()
    {
        $prices = Product::active()
            ->withActiveCategory()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return [
            'min' => (int) ($prices->min_price ?? 0),
            'max' => (int) ($prices->max_price ?? 100000),
        ];
    }

    /**
     * Extract filter parameters from request for view.
     */
    protected function getFilterParameters(Request $request)
    {
        return [
            'search'    => $request->get('search'),
            'category'  => $request->get('category'),
            'minPrice'  => $request->get('min_price'),
            'maxPrice'  => $request->get('max_price'),
            'sort'      => $request->get('sort', 'latest'),
            'status'    => $request->get('status'),
        ];
    }

    /**
     * Apply sorting to query (mirrors index method).
     */
    protected function applySorting($query, string $sort): void
    {
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name_en', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name_en', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc')
                    ->orderBy('average_rating', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
                break;
            case 'newest':
            case 'latest':
            default:
                $query->latest('created_at');
                break;
        }
    }

    /**
     * Display the specified product
     */

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->select([
                'id',
                'name_en',
                'name_bn',
                'slug',
                'sku',
                'model_number',
                'price',
                'compare_price',
                'discount_percentage',
                'short_description_en',
                'short_description_bn',
                'description_en',
                'description_bn',
                'featured_images',
                'gallery_images',
                'stock_status',
                'quantity',
                'category_id',
                'weight',
                'length',
                'width',
                'height',
                'warranty_duration',
                'warranty_unit',
                'specifications',
                'average_rating',
                'rating_count',
                'total_sold'
            ])
            ->with([
                'category:id,name_en,name_bn,slug,parent_id,depth,is_active',
                'category.parent:id,name_en,name_bn,slug',
            ])
            ->firstOrFail();

        // Check category is active
        if ($product->category && !$product->category->is_active) {
            abort(404);
        }

        // OPTIMIZED: Get reviews with pagination
        $reviews = DB::table('reviews')
            ->join('users', 'reviews.user_id', '=', 'users.id')
            ->where('reviews.product_id', $product->id)
            ->where('reviews.is_approved', true)
            ->select([
                'reviews.id',
                'reviews.rating',
                'reviews.comment',
                'reviews.created_at',
                'users.name as user_name',
                'users.avatar as user_avatar'
            ])
            ->orderBy('reviews.created_at', 'desc')
            ->limit(10)
            ->get();

        // OPTIMIZED: Get related products with raw query
        $relatedProducts = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $product->id)
            ->where('products.status', 'active')
            ->where('categories.is_active', true)
            ->where('products.stock_status', 'in_stock')
            ->select([
                'products.id',
                'products.name_en',
                'products.name_bn',
                'products.slug',
                'products.price',
                'products.compare_price',
                'products.discount_percentage',
                'products.featured_images',
                'products.stock_status',
                'products.average_rating',
                'products.rating_count'
            ])
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Get breadcrumbs
        $breadcrumbs = $this->getBreadcrumbsOptimized($product);
        // dd($breadcrumbs);
        // Track view (async, no performance impact)
        $this->trackProductView($product);

        return view('frontend.products.show', compact('product', 'reviews', 'relatedProducts', 'breadcrumbs'));
    }

    /**
     * Get breadcrumbs for product
     */
    protected function getBreadcrumbsOptimized($product): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Products', 'url' => route('products.index')],
        ];

        if ($product->category) {
            // Add category chain
            if ($product->category->parent) {
                $breadcrumbs[] = [
                    'name' => $product->category->parent->name,
                    'url' => route('categories.show', $product->category->parent->slug)
                ];
            }

            $breadcrumbs[] = [
                'name' => $product->category->name,
                'url' => route('categories.show', $product->category->slug)
            ];
        }

        $breadcrumbs[] = [
            'name' => $product->name,
            'url' => null
        ];

        return $breadcrumbs;
    }

    /**
     * Track product view
     */
    protected function trackProductView($product): void
    {
        // Increment view count (async job recommended for production)
        DB::table('products')
            ->where('id', $product->id)
            ->increment('views_count');
    }

    /**
     * Get products by category (alternative route)
     */
    public function category($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->active()
            ->firstOrFail();

        // Check if category hierarchy is fully active
        if (!$category->isFullyActive()) {
            abort(404, 'Category not available');
        }

        // Get all category IDs including descendants
        $categoryIds = $category->getAllCategoryIds();

        $products = Product::query()
            ->with(['category:id,name_en,name_bn,slug'])
            ->active()
            ->withActiveCategory()
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->paginate(24);

        // Get subcategories
        $subCategories = $category->children()
            ->active()
            ->withCount(['products' => function ($query) {
                $query->active()->withActiveCategory();
            }])
            ->get();

        return view('frontend.products.category', compact('category', 'products', 'subCategories'));
    }
}
