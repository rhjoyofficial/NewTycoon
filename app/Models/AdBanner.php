<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdBanner extends Model
{
    protected $fillable = ['title', 'images', 'link', 'is_active', 'order'];
    protected $casts = [
        'images' => 'array',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'ad_banner_id', 'id');
    }
    
    public function getSlidesAttribute()
    {
        return collect($this->images)->map(function ($img) {
            return asset('storage/' . $img);
        });
    }
}
