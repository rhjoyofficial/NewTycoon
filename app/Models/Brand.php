<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_bn',
        'description_en',
        'description_bn',
        'slug',
        'logo',
        'order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name_en);
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name_en') && empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name_en);
            }
        });
    }

    /**
     * Get the products for the brand.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include featured brands.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include active brands.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the brand's logo URL.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            if (strpos($this->logo, 'http') === 0) {
                return $this->logo;
            }

            return Storage::url($this->logo);
        }

        return asset('images/default-brand.png');
    }

    /**
     * Get the brand's URL.
     */
    public function getUrlAttribute()
    {
        return route('brands.show', $this->slug);
    }

    /**
     * Get total products count.
     */
    public function getTotalProductsAttribute()
    {
        return $this->products()->count();
    }

    /**
     * Get total sales revenue.
     */
    public function getTotalRevenueAttribute()
    {
        return $this->products()->sum('total_revenue');
    }
}
