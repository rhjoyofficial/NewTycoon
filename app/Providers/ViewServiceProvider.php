<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Footer;
use App\Models\Category;
use App\Services\FooterService;
use App\Services\SearchService;
use App\Services\NavigationService;
use App\Services\SearchTermService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /** * Register services. */
    public function register(): void
    {
        //
    }
    /** * Bootstrap services. */
    public function boot()
    {

        View::composer('*', function ($view) {
            $navigation = app(NavigationService::class)->getNavigationCategories();
            $view->with('navigation', $navigation);
        });

        View::composer('*', function ($view) {
            $categoriesDropdown = app(SearchService::class)->getCategoryTree();
            $view->with('categoriesDropdown', $categoriesDropdown);
        });

        View::composer('*', function ($view) {
            $topSearchedTerms = app(SearchTermService::class)->getTopSearchedTerms(8);
            $view->with('topSearchedTerms', $topSearchedTerms);
        });

        // Global Cart Data for authenticated users
        View::composer('*', function ($view) {

            $cartCount = 0;

            if (Auth::check()) {
                $cart = Cart::getCurrentCart();
                $cartCount = $cart?->total_items ?? 0;
            } else {
                // Guest users also can have cart (optional)
                $cart = Cart::getCurrentCart();
                $cartCount = $cart?->total_items ?? 0;
            }

            $view->with('cartCount', $cartCount);
        });


        // Global Footer Data 
        View::composer('*', function ($view) {

            $footerData = app(FooterService::class)->getFooterData();

            $view->with('footerData', $footerData);
        });
    }
}
