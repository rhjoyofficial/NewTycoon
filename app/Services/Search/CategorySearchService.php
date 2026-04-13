<?php

namespace App\Services\Search;

use App\Models\Category;
use App\Models\Product;

class CategorySearchService
{
    /**
     * Resolve category IDs based on search term
     */
    public function resolveCategoryIds(?string $search): array
    {
        if (!$search) {
            return Category::active()->pluck('id')->all();
        }

        // 1. Direct category matches (bilingual)
        $matchedCategoryIds = Category::active()
            ->where(function ($query) use ($search) {
                $query->where('name_en', 'LIKE', "%{$search}%")
                    ->orWhere('name_bn', 'LIKE', "%{$search}%");
            })
            ->pluck('id')
            ->all();

        // 2. Categories from products matching keyword
        $productCategoryIds = Product::active()
            ->search($search)
            ->pluck('category_id')
            ->unique()
            ->filter() // Remove nulls
            ->all();

        // 3. Get parent categories of matched categories
        $allCategoryIds = array_unique([
            ...$matchedCategoryIds,
            ...$productCategoryIds,
        ]);

        // Include parent categories
        if (!empty($allCategoryIds)) {
            $parentIds = Category::whereIn('id', $allCategoryIds)
                ->whereNotNull('parent_id')
                ->pluck('parent_id')
                ->unique()
                ->all();

            $allCategoryIds = array_unique([
                ...$allCategoryIds,
                ...$parentIds
            ]);
        }

        return array_values($allCategoryIds);
    }

    /**
     * Get all child category IDs for a given category
     */
    public function getCategoryChilednsIds(int $categoryId): array
    {
        $childIds = Category::where('parent_id', $categoryId)->pluck('id')->all();

        // Recursively get children's children
        foreach ($childIds as $childId) {
            $childIds = array_merge($childIds, $this->getCategoryChilednsIds($childId));
        }
        $childIds[] = $categoryId;
        return array_values($childIds);
    }
    /**
     * Get sidebar categories with product counts
     */
    public function getSidebarCategories(?string $search)
    {
        $categoryIds = $this->resolveCategoryIds($search);

        return Category::active()
            ->whereIn('id', $categoryIds)
            ->withCount([
                'products as products_count' => function ($q) use ($search) {
                    $q->active()
                        ->when($search, fn($query) => $query->search($search));
                }
            ])
            ->orderBy('order')
            ->orderBy('name_en')
            ->get();
    }

    /**
     * Get categories with product counts (for filters)
     */
    public function getCategoriesWithProductCounts(?string $search)
    {
        $categoryIds = $this->resolveCategoryIds($search);

        // Get only parent categories with their children
        return Category::active()
            ->whereIn('id', $categoryIds)
            ->whereNull('parent_id') // Only parents
            ->with([
                'children' => function ($q) use ($search, $categoryIds) {
                    $q->active()
                        ->whereIn('id', $categoryIds) // Only matched children
                        ->withCount([
                            'products as products_count' => function ($query) use ($search) {
                                $query->active()
                                    ->when($search, fn($q) => $q->search($search));
                            }
                        ])
                        ->orderBy('order');
                }
            ])
            ->withCount([
                'products as products_count' => function ($q) use ($search) {
                    $q->active()
                        ->when($search, fn($query) => $query->search($search));
                }
            ])
            ->having('products_count', '>', 0) // Only categories with products
            ->orderBy('order')
            ->orderBy('name_en')
            ->get();
    }

    /**
     * Get all categories for dropdown/filter
     */
    public function getAllActiveCategories()
    {
        return Category::active()
            ->whereNull('parent_id')
            ->with(['children' => fn($q) => $q->active()->orderBy('order')])
            ->orderBy('order')
            ->get();
    }
}
