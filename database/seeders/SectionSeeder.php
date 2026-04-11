<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\AdBanner;

class SectionSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | 1. CREATE BANNERS
        |--------------------------------------------------------------------------
        */

        $mainPromo = AdBanner::updateOrCreate(
            ['title' => 'Homepage Main Promo'],
            [
                'images' => [
                    'ads-banner/banner1.jpg'
                ],
                'link' => '/offers',
                'order' => 1,
                'is_active' => true,
            ]
        );

        $dualPromo = AdBanner::updateOrCreate(
            ['title' => 'Homepage Dual Promo'],
            [
                'images' => [
                    'ads-banner/banner2.jpg',
                    'ads-banner/banner3.jpg',
                ],
                'link' => '/summer-sale',
                'order' => 2,
                'is_active' => true,
            ]
        );

        $triplePromo = AdBanner::updateOrCreate(
            ['title' => 'Homepage Triple Promo'],
            [
                'images' => [
                    'ads-banner/banner4.jpg',
                    'ads-banner/banner5.jpg',
                    'ads-banner/banner6.jpg',
                ],
                'link' => '/mega-deal',
                'order' => 3,
                'is_active' => true,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | 2. PRODUCT SLIDER SECTIONS
        |--------------------------------------------------------------------------
        */

        $productSections = [

            [
                'name' => 'Homepage New Arrivals',
                'title_en' => 'New Arrivals',
                'title_bn' => 'নতুন আসা পণ্য',
                'product_type' => 'new_arrivals',
                'order' => 1,
                'banner' => $mainPromo
            ],

            [
                'name' => 'Homepage Best Sells',
                'title_en' => 'Best Selling Products',
                'title_bn' => 'সবচেয়ে বেশী বিক্রি পণ্য',
                'product_type' => 'best_sells',
                'order' => 2,
                'banner' => $mainPromo
            ],

            [
                'name' => 'Homepage Recommended',
                'title_en' => 'Recommended For You',
                'title_bn' => 'আপনার জন্য প্রস্তাবিত',
                'product_type' => 'recommended',
                'order' => 3,
                'banner' => $mainPromo
            ],
        ];

        foreach ($productSections as $item) {

            Section::updateOrCreate(
                ['name' => $item['name']],
                [
                    'title_en' => $item['title_en'],
                    'title_bn' => $item['title_bn'],
                    'type' => 'product_slider',
                    'order' => $item['order'],
                    'ad_banner_id' => $item['banner']->id,

                    'settings' => [
                        'product_type'   => $item['product_type'],
                        'slidesPerView'  => 5,
                        'autoPlay'       => true,
                        'showNavigation' => true,
                        'showPagination' => false,
                    ],
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 3. PURE BANNER SECTION
        |--------------------------------------------------------------------------
        */

        Section::updateOrCreate(
            ['name' => 'Homepage Mid Banner'],
            [
                'title_en' => 'Mid-Page Promotion',
                'title_bn' => 'মধ্য পৃষ্ঠার প্রচারণা',
                'type' => 'banner',
                'order' => 4,
                'ad_banner_id' => $mainPromo->id,
                'is_active' => true,
            ]
        );
    }
}
