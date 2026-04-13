<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCardViewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name, // Uses accessor for current locale
            'slug' => $this->slug,
            'url' => route('product.show', $this->slug), // Add product URL

            'price' => (float) $this->price,
            'compare_price' => $this->compare_price ? (float) $this->compare_price : null,
            'discount_percentage' => (int) $this->discount_percentage,
            'discount_amount' => $this->discount_amount, // Add discount amount

            'is_new' => (bool) $this->is_new,
            'in_stock' => $this->stock_status === 'in_stock',
            'is_featured' => (bool) $this->is_featured,
            'is_bestsells' => (bool) $this->is_bestsells, // Add bestseller flag

            // Images
            'image' => $this->featured_image_url, // Use accessor
            'featured_images' => $this->featured_images_urls, // Add all images

            // Additional useful fields
            'average_rating' => (float) $this->average_rating,
            'rating_count' => (int) $this->rating_count,
            'stock_status' => $this->stock_status,

            // Category info
            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],
        ];
    }
}
