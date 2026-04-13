<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $catalogs = [
            [
                'title' => 'Tycoon Electronics Corporate Profile 2026',
                'company_name' => 'Tycoon Electronics',
                'description' => 'Complete company profile including mission, vision, distribution network and manufacturing capacity.',
                'thumbnail' => 'catalogs/thumbnails/corporate-profile-2026.jpg',
                'pdf_file' => 'catalogs/pdfs/corporate-profile-2026.pdf',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Home Appliances Product Catalog 2026',
                'company_name' => 'Tycoon Electronics',
                'description' => 'Full range of refrigerators, air conditioners, washing machines and kitchen appliances.',
                'thumbnail' => 'catalogs/thumbnails/home-appliances-2026.jpg',
                'pdf_file' => 'catalogs/pdfs/home-appliances-2026.pdf',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Consumer Electronics Catalog 2026',
                'company_name' => 'Tycoon Electronics',
                'description' => 'LED TVs, sound systems, smart devices and accessories product line brochure.',
                'thumbnail' => 'catalogs/thumbnails/consumer-electronics-2026.jpg',
                'pdf_file' => 'catalogs/pdfs/consumer-electronics-2026.pdf',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Industrial & Commercial Equipment Catalog',
                'company_name' => 'Tycoon Electronics',
                'description' => 'Heavy-duty electrical equipment and commercial-grade solutions.',
                'thumbnail' => 'catalogs/thumbnails/industrial-equipment.jpg',
                'pdf_file' => 'catalogs/pdfs/industrial-equipment.pdf',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Spare Parts & Accessories Catalog 2026',
                'company_name' => 'Tycoon Electronics',
                'description' => 'Complete spare parts, components and certified accessories list.',
                'thumbnail' => 'catalogs/thumbnails/spare-parts-2026.jpg',
                'pdf_file' => 'catalogs/pdfs/spare-parts-2026.pdf',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($catalogs as $catalog) {
            Catalog::updateOrCreate(
                ['slug' => Str::slug($catalog['title'])],
                $catalog
            );
        }
    }
}
