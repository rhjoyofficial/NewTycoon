<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\SearchTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Search\ProductSearchService;
use App\Services\Search\CategorySearchService;

class SearchController extends Controller
{
    public function __construct(
        protected CategorySearchService $categoryService,
        protected ProductSearchService $productService,
    ) {}

    public function suggest(Request $request)
    {
        try {
            $query = $request->input('q', '');

            if (empty($query) || strlen($query) < 2) {
                return response()->json([]);
            }

            // Track search first
            if ($query) {
                SearchTerm::updateOrCreate(
                    ['term' => $query],
                    [
                        'search_count' => DB::raw('search_count + 1'),
                        'last_searched_at' => now(),
                    ]
                );
            }

            // ISSUE: Using 'name' instead of bilingual fields
            $products = Product::active()
                ->where(function ($q) use ($query) {
                    $q->where('name_en', 'LIKE', "%{$query}%")
                        ->orWhere('name_bn', 'LIKE', "%{$query}%")
                        ->orWhere('sku', 'LIKE', "%{$query}%")
                        ->orWhere('model_number', 'LIKE', "%{$query}%");
                    // ->orWhere('short_description_en', 'LIKE', "%{$query}%")
                    // ->orWhere('short_description_bn', 'LIKE', "%{$query}%");
                })
                ->limit(8)
                ->get(['id', 'name_en', 'name_bn', 'slug', 'price', 'featured_images', 'stock_status', 'is_new', 'discount_percentage']);

            // ISSUE: Using 'name' instead of bilingual fields
            $categories = Category::active()
                ->where(function ($q) use ($query) {
                    $q->where('name_en', 'LIKE', "%{$query}%")
                        ->orWhere('name_bn', 'LIKE', "%{$query}%");
                })
                ->limit(5)
                ->get(['id', 'name_en', 'name_bn', 'slug']);

            $suggestions = [];

            // Add products to suggestions
            foreach ($products as $product) {
                $suggestions[] = [
                    'type' => 'product',
                    'id' => $product->id,
                    'name' => $product->name, // This will use accessor
                    'url' => route('product.show', $product->slug),
                    'price' => number_format($product->price, 2),
                    'image' => $this->getImageUrl($product->featured_images[0] ?? null),
                    'in_stock' => $product->stock_status === 'in_stock',
                    'is_new' => $product->is_new,
                    'discount_percentage' => $product->discount_percentage,
                    'highlight' => $this->highlightText($product->name, $query)
                ];
            }

            // Add categories to suggestions
            foreach ($categories as $category) {
                $suggestions[] = [
                    'type' => 'category',
                    'id' => $category->id,
                    'name' => $category->name, // This will use accessor
                    'url' => route('categories.show', $category->slug),
                    'highlight' => $this->highlightText($category->name, $query)
                ];
            }

            return response()->json($suggestions);
        } catch (\Exception $e) {
            Log::error('Search suggestion error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'An error occurred while searching',
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    private function getImageUrl($imagePath)
    {
        if (!$imagePath) {
            return asset('images/products/default.jpg'); // Use proper default
        }

        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }

        return asset('storage/' . ltrim($imagePath, '/'));
    }

    private function highlightText($text, $query)
    {
        if (empty($query)) {
            return e($text);
        }

        $pattern = '/(' . preg_quote($query, '/') . ')/i';
        $highlighted = preg_replace($pattern, '<span class="font-bold text-primary">$1</span>', e($text));

        return $highlighted ?: e($text);
    }

    public function search(Request $request)
    {
        $search = trim($request->input('q', ''));
        $sort = $request->input('sort', 'latest');
        $category = $request->input('category');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $status = $request->input('status', 'all');
        $currentCategory = null;

        if ($request->filled('category')) {
            $currentCategory = Category::find($request->category);
        }

        if ($category) {
            $categoryIds = $this->categoryService->getCategoryChilednsIds($category);
        } else {
            $categoryIds = $this->categoryService->resolveCategoryIds($search);
        }

        $productQuery = $this->productService->buildQuery(
            $search,
            $minPrice,
            $maxPrice,
            $status,
            $categoryIds
        );
        // dd($productQuery->toSql(), $productQuery->getBindings());
        $this->applySorting($productQuery, $sort);

        // Track search term
        if ($search && strlen($search) >= 2) {
            SearchTerm::updateOrCreate(
                ['term' => $search],
                [
                    'search_count' => DB::raw('search_count + 1'),
                    'last_searched_at' => now(),
                ]
            );
        }

        $products = $productQuery->paginate(12)->withQueryString();

        $categories = $this->categoryService->getCategoriesWithProductCounts($search);

        // Get price range for filters
        $priceRange = $this->getPriceRange($productQuery);

        // Get total products count for "All Categories"
        $allProductsCount = $this->getAllProductsCount($search);

        // dd($products, $categories, $category, $allProductsCount);

        return view('frontend.search.results', [
            'products' => $products,
            'categories' => $categories,
            'priceRange' => $priceRange,
            'search' => $search,
            'category' => $category,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'sort' => $sort,
            'status' => $status,
            'allProductsCount' => $allProductsCount,
            'currentCategory' => $currentCategory,
        ]);
    }

    public function popular()
    {
        $terms = SearchTerm::orderByDesc('search_count')
            ->limit(8)
            ->get(['id', 'term', 'search_count', 'last_searched_at']);

        return response()->json($terms);
    }

    /**
     * Get all products count for search
     */
    private function getAllProductsCount($search)
    {
        $categoryIds = $this->categoryService->resolveCategoryIds($search);

        return Product::active()
            ->whereIn('category_id', $categoryIds)
            ->when($search, fn($q) => $q->search($search))
            ->count();
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query, $sort)
    {
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }
    }

    /**
     * Get price range for current filters
     */
    private function getPriceRange($query)
    {
        // Clone query to get min/max without affecting pagination
        $rangeQuery = clone $query;

        return [
            'min' => (float) ($rangeQuery->min('price') ?? 0),
            'max' => (float) ($rangeQuery->max('price') ?? 10000)
        ];
    }
}
