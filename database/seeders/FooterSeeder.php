<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterColumn;
use App\Models\FooterLink;
use App\Models\FooterSetting;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------
        // Footer Settings
        // -------------------------
        FooterSetting::query()->delete();

        FooterSetting::create([
            'brand_name' => 'TYCOON',
            'brand_description_en' =>
            'Your premier destination for cutting-edge technology and electronics. We bring you the latest innovations with exceptional quality and service.',
            'brand_description_bn' =>
            'আধুনিক প্রযুক্তি ও ইলেকট্রনিক্সের জন্য আপনার বিশ্বস্ত গন্তব্য। আমরা সর্বশেষ উদ্ভাবন এবং সেরা মানের সেবা প্রদান করি।',
            'contact_info' => [
                "hotline_1" => "+8801234567890",
                "hotline_2" => "+8801987654321",
                "email_1" => "info@example.com",
                "email_2" => "support@example.com"
            ],
            'payment_methods' => [
                'https://cdn-icons-png.flaticon.com/512/196/196578.png',
                'https://cdn-icons-png.flaticon.com/512/196/196561.png',
                'https://cdn-icons-png.flaticon.com/512/196/196539.png',
                'https://cdn-icons-png.flaticon.com/512/888/888871.png',
                'https://cdn-icons-png.flaticon.com/512/888/888879.png',
                'https://cdn-icons-png.flaticon.com/512/888/888870.png',
            ],
            'social_links' => [
                'facebook'  => '#',
                'twitter'   => '#',
                'instagram' => '#',
                'linkedin'  => '#',
            ],
        ]);

        // -------------------------
        // Footer Columns + Links
        // -------------------------
        FooterColumn::query()->delete();
        FooterLink::query()->delete();

        $columns = [
            [
                'title_en' => 'About Tycoon',
                'title_bn' => 'টাইকুন সম্পর্কে',
                'links' => [
                    ['en' => 'About Us', 'bn' => 'আমাদের সম্পর্কে', 'url' => '/about-us'],
                    ['en' => 'Technology & Innovation', 'bn' => 'প্রযুক্তি ও উদ্ভাবন', 'url' => '/technology-and-innovation'],
                    ['en' => 'Quality & Certifications', 'bn' => 'গুণগত মান ও সার্টিফিকেশন', 'url' => '/certifications'],
                    ['en' => 'Brand Partners', 'bn' => 'ব্র্যান্ড পার্টনার', 'url' => '/partners'],
                    ['en' => 'Sustainability', 'bn' => 'টেকসই উন্নয়ন', 'url' => '/sustainability'],
                ],
            ],
            [
                'title_en' => 'Customer Help',
                'title_bn' => 'গ্রাহক সহায়তা',
                'links' => [
                    ['en' => 'How to Order', 'bn' => 'কিভাবে অর্ডার করবেন', 'url' => '/how-to-order'],
                    ['en' => 'Delivery Information', 'bn' => 'ডেলিভারি তথ্য', 'url' => '/shipping'],
                    ['en' => 'Return & Replacement', 'bn' => 'রিটার্ন ও রিপ্লেসমেন্ট', 'url' => '/returns'],
                    ['en' => 'FAQ', 'bn' => 'প্রশ্নোত্তর', 'url' => '/faq'],
                ],
            ],
            [
                'title_en' => 'Products',
                'title_bn' => 'পণ্যসমূহ',
                'links' => [
                    ['en' => 'All Products', 'bn' => 'সব পণ্য', 'url' => '/products'],
                    ['en' => 'All Categories', 'bn' => 'সব ক্যাটাগরি', 'url' => '/categories'],
                    ['en' => 'New Arrivals', 'bn' => 'নতুন পণ্য', 'url' => '/new-arrivals'],
                    ['en' => 'Best Sellers', 'bn' => 'সেরা বিক্রিত', 'url' => '/best-sellers'],
                    ['en' => 'Special Offers', 'bn' => 'বিশেষ অফার', 'url' => '/offers'],
                ],
            ],
            [
                'title_en' => 'Legal & Policies',
                'title_bn' => 'আইনি নীতিমালা',
                'links' => [
                    ['en' => 'Privacy Policy', 'bn' => 'প্রাইভেসি পলিসি', 'url' => '/privacy'],
                    ['en' => 'Terms & Conditions', 'bn' => 'শর্তাবলী', 'url' => '/terms'],
                ],
            ],
        ];

        foreach ($columns as $index => $columnData) {
            $column = FooterColumn::create([
                'title_en'   => $columnData['title_en'],
                'title_bn'   => $columnData['title_bn'],
                'sort_order' => $index + 1,
                'is_active'  => true,
            ]);

            foreach ($columnData['links'] as $linkIndex => $link) {
                FooterLink::create([
                    'footer_column_id' => $column->id,
                    'title_en' => $link['en'],
                    'title_bn' => $link['bn'],
                    'url' => $link['url'],
                    'sort_order' => $linkIndex + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
}
