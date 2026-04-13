<?php

namespace App\Services\Product;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * Get navigation categories (cached)
     */
    public function getNavigation(): array
    {
        return Cache::remember('navigation', 3600, function () {
            $categories = Category::active()
                ->featured()
                ->root()
                ->with('children') // eager load first level
                ->orderBy('order')
                ->get();

            return $categories->map(fn($category) => $this->formatCategoryForNavigation($category))->toArray();
        });
    }

    /**
     * Format category for navigation recursively
     */
    protected function formatCategoryForNavigation(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'url' => $category->url,
            'children' => $category->children
                ->where('is_active', true)
                ->sortBy('order')
                ->map(fn($child) => $this->formatCategoryForNavigation($child))
                ->values() // reset array keys
                ->toArray(),
        ];
    }
}
