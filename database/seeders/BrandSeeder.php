<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {

        Brand::create([
            'name_en' => 'TYCOON',
            'name_bn' => 'টাইকুন',
            'description_en' => 'Premium home appliances and electronics brand',
            'description_bn' => 'প্রিমিয়াম হোম অ্যাপ্লায়েন্সেস এবং ইলেকট্রনিক্স ব্র্যান্ড',
            'slug' => 'tycoon',
            'is_active' => true,
        ]);
        
    }
}
