<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ActiveProductService
{
    /**
     * Get all active products with fully active category hierarchy.
     */
    public function getAllActiveProducts(int $perPage = 24, array $withRelations = ['category']): LengthAwarePaginator
    {
        return Product::with($withRelations)
            ->active()
            ->withActiveCategory()
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get featured products with active category hierarchy.
     */
    public function getActiveFeaturedProducts(int $limit = 12, array $withRelations = ['category']): Collection
    {
        return Product::with($withRelations)
            ->active()
            ->inStock()
            ->withActiveCategory()
            ->featured()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get new arrivals with active category hierarchy.
     */
    public function getActiveNewArrivals(int $limit = 12, array $withRelations = ['category']): Collection
    {
        return Product::with($withRelations)
            ->active()
            ->withActiveCategory()
            ->new()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Get bestsellers with active category hierarchy.
     */
    public function getActiveBestSells(int $limit = 12, array $withRelations = ['category']): Collection
    {
        return Product::with($withRelations)
            ->active()
            ->withActiveCategory()
            ->where(function ($q) {
                $q->where('is_bestsells', true)
                    ->orWhere('average_rating', '>=', 4.2)
                    ->orWhere('total_sold', '>', 50);
            })
            ->latest()
            ->orderByDesc('average_rating')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
    /**
     * Get bestsellers with active category hierarchy.
     */
    public function getActiveRecommendedProducts(int $limit = 12, array $withRelations = ['category']): Collection
    {
        return Product::with($withRelations)
            ->active()
            ->withActiveCategory()
            ->inStock()
            ->orderByDesc('total_sold')
            ->orderByDesc('average_rating')
            ->limit($limit)
            ->get();
    }

    /**
     * Get Offer Products where discount more than 10% with active category hierarchy.
     */
    public function getActiveOfferProducts(int $limit = 12, array $withRelations = ['category'], float $minDiscount = 10): Collection
    {
        return Product::with($withRelations)
            ->active()
            ->withActiveCategory()
            ->inStock()
            ->offerAbove($minDiscount)
            ->orderByDesc('discount_percentage')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }


    /**
     * Get products by category with active hierarchy check.
     */
    public function getProductsByActiveCategory(Category $category, int $perPage = 24, array $filters = []): LengthAwarePaginator
    {
        // First verify the category and all its parents are active
        if (!$category->isFullyActive()) {
            return new LengthAwarePaginator([], 0, $perPage);
        }

        $query = Product::with(['category'])
            ->withActiveCategory()
            ->where('category_id', $category->id);

        // Apply filters
        $this->applyFilters($query, $filters);

        return $query->paginate($perPage);
    }

    /**
     * Get products by category slug with active hierarchy check.
     */
    public function getProductsByActiveCategorySlug(string $slug, int $perPage = 24, array $filters = []): ?LengthAwarePaginator
    {
        $category = Category::where('slug', $slug)
            ->activeWithActiveParents()
            ->first();

        if (!$category) {
            return null;
        }

        return $this->getProductsByActiveCategory($category, $perPage, $filters);
    }

    /**
     * Search active products.
     */
    public function searchActiveProducts(string $searchTerm, int $perPage = 24, array $filters = []): LengthAwarePaginator
    {
        $query = Product::with(['category'])
            ->withActiveCategory()
            ->search($searchTerm);

        // Apply filters
        $this->applyFilters($query, $filters);

        return $query->paginate($perPage);
    }

    /**
     * Get related active products.
     */
    public function getActiveRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::with(['category'])
            ->withActiveCategory()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get products for homepage with active category check.
     */
    public function getHomepageActiveProducts(): array
    {
        return [
            'featured' => $this->getActiveFeaturedProducts(8),
            'new_arrivals' => $this->getActiveNewArrivals(8),
            'bestsellers' => $this->getActiveBestSells(8),
        ];
    }

    /**
     * Check if a product is fully active (product + category hierarchy).
     */
    public function isProductFullyActive(Product $product): bool
    {
        if ($product->status !== 'active') {
            return false;
        }

        if (!$product->category) {
            return false;
        }

        return $product->category->isFullyActive();
    }

    /**
     * Get count of fully active products.
     */
    public function getActiveProductsCount(): int
    {
        return Product::withActiveCategory()->count();
    }

    /**
     * Apply filters to query.
     */
    protected function applyFilters($query, array $filters): void
    {
        // Price range filter
        if (!empty($filters['min_price']) || !empty($filters['max_price'])) {
            $min = $filters['min_price'] ?? 0;
            $max = $filters['max_price'] ?? 99999999;
            $query->priceRange($min, $max);
        }

        // Stock filter
        if (isset($filters['in_stock']) && $filters['in_stock']) {
            $query->inStock();
        }

        // Sort filter
        if (!empty($filters['sort'])) {
            $this->applySorting($query, $filters['sort']);
        }
    }

    /**
     * Apply sorting to query.
     */
    protected function applySorting($query, string $sort): void
    {
        switch ($sort) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'popular':
                $query->orderBy('total_sold', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            default:
                $query->latest();
        }
    }
}
