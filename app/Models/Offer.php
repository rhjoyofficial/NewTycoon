<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title_en',
        'title_bn',
        'short_des_en',
        'short_des_bn',
        'slug',
        'subtitle_en',
        'subtitle_bn',
        'main_banner_image',
        'timer_enabled',
        'timer_end_date',
        'view_all_link',
        'view_all_text',
        'product_source',
        'source_config',
        'product_limit',
        'status',
        'start_date',
        'end_date',
        'order',
        'view_count',
        'click_count',
    ];

    protected $casts = [
        'timer_enabled' => 'boolean',
        'timer_end_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'source_config' => 'array',
        'view_count' => 'integer',
        'click_count' => 'integer',
    ];

    protected $appends = [
        'is_active',
        'products_count',
        'main_banner_url',
        'time_left',
    ];

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($offer) {
            if (empty($offer->slug)) {
                $offer->slug = Str::slug($offer->title_en);
            }
        });

        static::updating(function ($offer) {
            if ($offer->isDirty('title_en') && empty($offer->slug)) {
                $offer->slug = Str::slug($offer->title_en);
            }
        });

        static::saved(function () {
            Cache::forget('active_offers');
        });

        static::deleted(function () {
            Cache::forget('active_offers');
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'offer_products')
            ->withPivot(['order', 'custom_data'])
            ->orderBy('offer_products.order')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('order')
            ->orderBy('created_at', 'desc');
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' &&
            (!$this->start_date || $this->start_date <= now()) &&
            (!$this->end_date || $this->end_date >= now());
    }

    public function getProductsCountAttribute(): int
    {
        return Cache::remember("offer.{$this->id}.products_count", 3600, function () {
            return $this->products()->count();
        });
    }

    public function getMainBannerUrlAttribute(): ?string
    {
        if ($this->main_banner_image) {
            return asset('storage/' . $this->main_banner_image);
        }

        return asset('images/offers/main-banner.jpeg');
    }

    public function getTimeLeftAttribute(): ?int
    {
        if (!$this->timer_enabled || !$this->timer_end_date) {
            return null;
        }

        $diff = $this->timer_end_date->diffInSeconds(now(), false);
        return max(0, -$diff); // Return 0 if expired
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function incrementClickCount(): void
    {
        $this->increment('click_count');
    }

    public function getFormattedViewAllLinkAttribute(): string
    {
        if (!$this->view_all_link) {
            return route('products.index');
        }

        if (Str::startsWith($this->view_all_link, ['http://', 'https://', '/'])) {
            return $this->view_all_link;
        }

        try {
            return route($this->view_all_link);
        } catch (\Exception $e) {
            return route('products.index');
        }
    }

    /**
     * Get products based on source type
     */
    public function getSourceProducts()
    {
        switch ($this->product_source) {
            case 'discount':
                return $this->getDiscountProducts();
            case 'category':
                return $this->getCategoryProducts();
            case 'tag':
                return $this->getTagProducts();
            case 'manual':
            default:
                return $this->products()->with('category')->take($this->product_limit)->get();
        }
    }

    private function getDiscountProducts()
    {
        $minDiscount = $this->source_config['min_discount'] ?? 10;

        return Product::active()
            ->withActiveCategory()
            ->inStock()
            ->where('discount_percentage', '>=', $minDiscount)
            ->orderByDesc('discount_percentage')
            ->orderByDesc('total_sold')
            ->with('category')
            ->limit($this->product_limit)
            ->get();
    }

    private function getCategoryProducts()
    {
        $categoryIds = $this->source_config['category_ids'] ?? [];

        if (empty($categoryIds)) {
            return collect();
        }

        return Product::active()
            ->withActiveCategory()
            ->inStock()
            ->whereIn('category_id', $categoryIds)
            ->orderByDesc('total_sold')
            ->with('category')
            ->limit($this->product_limit)
            ->get();
    }

    private function getTagProducts()
    {
        // Implement if you have tags
        return collect();
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() === 'bn' ? ($this->title_bn ?? $this->title_en) : $this->title_en;
    }

    public function getSubtitleAttribute()
    {
        return app()->getLocale() === 'bn' ? ($this->subtitle_bn ?? $this->subtitle_en) : $this->subtitle_en;
    }

    public function getShortDescriptionAttribute()
    {
        return app()->getLocale() === 'bn' ? ($this->short_des_bn ?? $this->short_des_en) : $this->short_des_en;
    }
}
