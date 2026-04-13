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
        // dd($heroSlides);

        // Get active categories with active parents
        $categories = Category::active()->featured()->limit(20)->get();
        // $categories = Cache::remember('homepage.featured.categories', 3600, function () {
        //     return Category::active()->root()->featured()->limit(12)->get();
        // });

        $products = $this->activeProductService->getHomepageActiveProducts();
        // Get active featured products
        $featuredProducts = $this->activeProductService->getActiveFeaturedProducts(8);
        // $featuredProducts = Cache::remember('homepage.featured.products', 3600, function () {
        //     return $this->activeProductService->getActiveFeaturedProducts(8);
        // });

        // $featuredProducts = FeaturedProductViewResource::collection($featuredProducts);
        // dd($featuredProducts);

        // Get new Arrivals products
        // $newArrivals = $this->activeProductService->getActiveNewArrivals();
        // $newArrivals = FeaturedProductViewResource::collection($newArrivals);
        // Get Best Sells products
        // $bestsells = $this->activeProductService->getActiveBestSells();
        // $bestsells = FeaturedProductViewResource::collection($bestsells);

        // Get Recommended Products products
        // $recommendedProducts = $this->activeProductService->getActiveRecommendedProducts();
        // $recommendedProducts = FeaturedProductViewResource::collection($recommendedProducts);

        // $smartSections = $this->smartSections();
        // $adsBanners = $this->getAdsBanners();
        // $adsAnotherBanners = $this->getAnotherAdsBanners();

        // Get active offer with products
        $offer = Offer::active()
            ->with(['products' => function ($query) {
                $query->with('category')->active()->inStock()->limit(12);
            }])
            ->first();

        // Get offer products based on source
        if ($offer) {
            $offerProducts = $offer->getSourceProducts();
        } else {
            $offerProducts = collect();
        }

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
        // dd($this->activeProductService->getActiveNewArrivals($limit = 50));
        return view('frontend.home', compact(
            'heroSlides',
            'categories',
            'featuredProducts',
            'products',
            'offer',
            'offerProducts',
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
