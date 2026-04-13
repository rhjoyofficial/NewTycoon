<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

class CategoryProductsService
{
    /**
     * Get all products for a category with filters
     */
    public function getCategoryProducts(
        Category $category,
        ?string $search = null,
        ?string $sort = 'latest',
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $status = 'all'
    ) {
        $query = $category->getProductsQuery($search);

        // Apply price filters
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply status filters
        $this->applyStatusFilter($query, $status);

        // Apply sorting
        $this->applySorting($query, $sort);

        return $query;
    }

    /**
     * Get related categories for filter sidebar
     */
    public function getRelatedCategoriesForSearch(Category $category, ?string $search = null): Collection
    {
        // Parent categories
        $parentCategories = $category->getParentCategories();

        // Sibling categories
        $siblingCategories = Category::active()
            ->where('parent_id', $category->parent_id)
            ->where('id', '!=', $category->id)
            ->get();

        // Child categories
        $childCategories = $category->children()->active()->get();

        // Merge all
        $allCategories = collect()
            ->merge($parentCategories)
            ->merge($siblingCategories)
            ->merge($childCategories)
            ->unique('id');

        // Attach product counts ONCE
        $allCategories = $allCategories->map(function ($cat) use ($search) {
            $cat->products_count = $cat->getProductsCount($search);
            return $cat;
        });

        // must have products
        if ($search) {
            $allCategories = $allCategories->filter(function ($cat) {
                return $cat->products_count > 0;
            });
        }

        return $allCategories->sortBy('order')->values();
    }


    /**
     * Get price range for category products
     */
    public function getPriceRange(Category $category, ?string $search = null): array
    {
        $query = $category->getProductsQuery($search);

        return [
            'min' => (float) ($query->min('price') ?? 0),
            'max' => (float) ($query->max('price') ?? 10000)
        ];
    }

    /**
     * Apply status filter to query
     */
    private function applyStatusFilter($query, string $status): void
    {
        switch ($status) {
            case 'in_stock':
                $query->where('stock_status', 'in_stock');
                break;
            case 'out_of_stock':
                $query->where('stock_status', 'out_of_stock');
                break;
            case 'new':
                $query->where('is_new', true);
                break;
            case 'discounted':
                $query->where('discount_percentage', '>', 0);
                break;
            case 'featured':
                $query->where('is_featured', true);
                break;
        }
    }

    /**
     * Apply sorting to query
     */
    private function applySorting($query, string $sort): void
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
}
