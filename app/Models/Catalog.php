<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Catalog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'company_name',
        'description',
        'thumbnail',
        'pdf_file',
        'is_active',
        'sort_order'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($catalog) {
            $catalog->slug = Str::slug($catalog->title);
        });
    }

    public function getPdfUrlAttribute()
    {
        return asset('storage/' . $this->pdf_file);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : null;
    }
}
