<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Section;
use App\Models\UserStory;
use App\Services\Product\ActiveProductService;
use App\Services\Product\ProductService;

class HomeController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ActiveProductService $activeProductService,
    ) {}

    public function index()
    {
        $heroSlides = HeroSlide::active()->sorted()->get();
        $categories = Category::active()->featured()->limit(20)->get();

        $products = $this->activeProductService->getHomepageActiveProducts();
        $featuredProducts = $this->activeProductService->getActiveFeaturedProducts(8);

        $offers = Offer::active()->get()->map(function ($offer) {
            $offer->offerProducts = $offer->getSourceProducts();
            return $offer;
        });

        $sections = Section::with('banner')->where('is_active', true)->orderBy('order')->get();
        $sections->transform(function ($section) {
            if ($section->type === 'product_slider') {
                $productType = $section->settings['product_type'] ?? 'new_arrivals';
                $section->products = match ($productType) {
                    'new_arrivals' => $this->activeProductService->getActiveNewArrivals(),
                    'best_sells'   => $this->activeProductService->getActiveBestSells(),
                    'recommended'  => $this->activeProductService->getActiveRecommendedProducts(),
                    default        => collect(),
                };
            }
            return $section;
        });

        return view('frontend.home', compact(
            'heroSlides',
            'categories',
            'featuredProducts',
            'products',
            'offers',
            'sections'
        ));
    }

    // keeding for now until we have real banners in db
    protected function getAdsBanners()
    {
        $adsBanners = AdBanner::where('is_active', true)
            ->orderBy('order')
            ->get();

        if ($adsBanners->isEmpty()) {
            $adsBanners = collect([
                (object)[
                    'image_path' => 'storage/ads-banner/airad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/tvad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/fanad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/kettelads.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
            ]);
        }

        return $adsBanners;
    }
    // keeding for now until we have real banners in db
    protected function getAnotherAdsBanners()
    {
        $adsBanners = AdBanner::where('is_active', true)
            ->orderBy('order')
            ->get();

        if ($adsBanners->isEmpty()) {
            $adsBanners = collect([
                (object)[
                    'image_path' => 'storage/ads-banner/watchad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/tvad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/frezze.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
                (object)[
                    'image_path' => 'storage/ads-banner/fanad.jpg',
                    'link' => '#',
                    'target' => '_self',
                ],
            ]);
        }

        return $adsBanners;
    }
}
