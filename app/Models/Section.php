<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'title_en',
        'title_bn',
        'type',
        'order',
        'is_active',
        'settings',
        'ad_banner_id'
    ];
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute(): string
    {
        return (string) (
            app()->isLocale('bn')
            ? ($this->title_bn ?? $this->title_en)
            : $this->title_en
        );
    }

    public function banner()
    {
        return $this->belongsTo(AdBanner::class, 'ad_banner_id', 'id');
    }
}
