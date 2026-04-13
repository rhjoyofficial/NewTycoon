<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        // HeroSlide::create([
        //     'type' => 'image',
        //     'background' => 'slides/demo-banner-no.png',
        //     'has_content' => true,
        //     'content_position' => 'center',
        //     'badge_en' => 'New',
        //     'badge_bn' => 'নতুন',
        //     'title_en' => 'Fresh Organic Products',
        //     'title_bn' => 'তাজা অর্গানিক পণ্য',
        //     'subtitle_en' => 'Delivered to your door',
        //     'subtitle_bn' => 'আপনার বাড়িতে পৌঁছে দিচ্ছি',
        //     'has_cta' => true,
        //     'cta_buttons' => [
        //         [
        //             'label_en' => 'Shop Now',
        //             'label_bn' => 'কিনুন',
        //             'url' => '/products',
        //             'style' => 'primary',
        //         ],
        //         [
        //             'label_en' => 'Learn More',
        //             'label_bn' => 'বিস্তারিত',
        //             'url' => '/about-us',
        //             'style' => 'outline',
        //         ],
        //     ],
        //     'is_active' => true,
        //     'sort_order' => 1,
        // ]);

        // HeroSlide::create([
        //     'type' => 'video',
        //     'background' => 'slides/hero-background.mp4',
        //     'has_content' => false,
        //     'content_position' => 'center',
        //     'has_cta' => false,
        //     'is_active' => true,
        //     'sort_order' => 4,
        // ]);

        // HeroSlide::create([
        //     'type' => 'image',
        //     'background' => 'slides/demo-banner-no.png',
        //     'has_content' => true,
        //     'content_position' => 'left',
        //     'title_en' => 'Seasonal Discounts',
        //     'title_bn' => 'মৌসুমী ছাড়',
        //     'subtitle_en' => 'Up to 50% Off!',
        //     'subtitle_bn' => '৫০% পর্যন্ত ছাড়!',
        //     'badge_en' => null,
        //     'badge_bn' => null,
        //     'has_cta' => true,
        //     'cta_buttons' => [
        //         [
        //             'label_en' => 'View Offers',
        //             'label_bn' => 'অফার দেখুন',
        //             'url' => '/offers',
        //             'style' => 'primary',
        //         ],
        //     ],
        //     'is_active' => true,
        //     'sort_order' => 3,
        // ]);

        $images = ['11', '22', '33', '44', '55', '66'];

        foreach ($images as $index => $name) {
            HeroSlide::create([
                'type'             => 'image',
                'background'       => "slides/banner{$name}.jpg",
                'has_content'      => false,
                'content_position' => 'center',
                'has_cta'          => false,
                'is_active'        => true,
                'sort_order'       => $index + 1, 
            ]);
        }
    }
}
