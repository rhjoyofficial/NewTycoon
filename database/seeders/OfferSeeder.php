<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        $offer = Offer::create([
            'title_en' => 'Winter Dhamaka Offer 2025',
            'title_bn' => 'বিশ্ব শীতকালের ডামাকা অফার ২০২৫',
            'slug' => Str::slug('Winter Dhamaka Offer 2025'),
            'subtitle_en' => 'Enjoy the coolest discounts of the season with up to 70% off!',
            'subtitle_bn' => 'মৌসুমের সবচেয়ে শীতল ডিসকাউন্টগুলি আপনি পাবেন 70% পর্যন্ত!',
            'short_des_en' => 'Limited time offer for winter season.',
            'short_des_bn' => 'শীতকালের জন্য সীমিত সময়ের অফার।',
            'timer_enabled' => true,
            'timer_end_date' => now()->addDays(7),
            'view_all_link' => 'products',
            'main_banner_image' => 'images/offers/main-banner.jpeg',
            'view_all_text' => 'View All',
            'product_source' => 'manual',
            'product_limit' => 8,
            'status' => 'active',
            'order' => 1,
        ]);

        // Attach products (latest discounted)
        Product::where('discount_percentage', '>', 10)
            ->latest()
            ->take(20)
            ->get()
            ->each(function ($product, $index) use ($offer) {
                $offer->products()->attach($product->id, [
                    'order' => $index,
                ]);
            });
    }
}
