<?php

namespace App\Services\Search;

use App\Models\Product;

class ProductSearchService
{
    public function buildQuery(
        ?string $search,
        ?float $minPrice,
        ?float $maxPrice,
        string $status,
        array $categoryIds
    ) {
        return Product::query()
            ->active()
            ->when($search, fn($q) => $q->search($search))
            ->when($categoryIds, fn($q) => $q->whereIn('category_id', $categoryIds))
            ->when(
                $minPrice !== null && $maxPrice !== null,
                fn($q) => $q->whereBetween('price', [$minPrice, $maxPrice])
            )
            ->with('category');
    }
}
