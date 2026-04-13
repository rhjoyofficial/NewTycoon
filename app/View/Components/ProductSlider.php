<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class ProductSlider extends Component
{
    public $slidingProducts;
    public $banner;
    public $title;
    public $sliderId;
    public $autoPlay;
    public $showNavigation;
    public $showPagination;
    public $slidesPerView;
    public $spaceBetween;
    public $cardStyle;

    public function __construct(
        $banner,
        $slidingProducts = [],
        $title = 'Recommended for you',
        $sliderId = 'productSlider',
        $autoPlay = true,
        $showNavigation = true,
        $showPagination = false,
        $slidesPerView = 4,
        $spaceBetween = 24,
        $cardStyle = 'modern'
    ) {
        $this->banner = $banner;
        $this->slidingProducts = $slidingProducts ?: [];
        $this->title = $title;
        $this->sliderId = $sliderId;
        $this->autoPlay = filter_var($autoPlay, FILTER_VALIDATE_BOOLEAN);
        $this->showNavigation = filter_var($showNavigation, FILTER_VALIDATE_BOOLEAN);
        $this->showPagination = filter_var($showPagination, FILTER_VALIDATE_BOOLEAN);
        $this->slidesPerView = (int) $slidesPerView;
        $this->spaceBetween = (int) $spaceBetween;
        $this->cardStyle = $cardStyle;
    }

    public function render(): View|Closure|string
    {
        return view('components.product-slider');
    }
}
