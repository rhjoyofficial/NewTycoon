<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * All products from PDFs mapped to categories
     */
    private $products = [
        // RICE COOKERS & MULTI COOKERS
        'Rice Cooker' => [
            ['name' => 'Tycoon Rice Cooker 2.8L Red 1000W', 'model' => 'TRM-2401R', 'price' => 4190, 'colors' => ['Red']],
            ['name' => 'Tycoon Rice Cooker 2.8L Yellow 1000W', 'model' => 'TRM-2401Y', 'price' => 4190, 'colors' => ['Yellow']],
            ['name' => 'Tycoon Rice Cooker 2.8L White 1000W', 'model' => 'TRM-2401W', 'price' => 4190, 'colors' => ['White']],
            ['name' => 'Tycoon Rice Cooker 2.8L Orange 1000W', 'model' => 'TRM-24010', 'price' => 4190, 'colors' => ['Orange']],
            ['name' => 'Tycoon Rice Cooker 2.8L Maroon 1000W', 'model' => 'TRM-2502M', 'price' => 4190, 'colors' => ['Maroon'], 'is_new' => true],
            ['name' => 'Tycoon Rice Cooker 2.8L Maroon SS Pots 1000W', 'model' => 'TRM-2502M-SS', 'price' => 4690, 'colors' => ['Maroon'], 'is_new' => true],
            ['name' => 'Tycoon Rice Cooker 3.2L Red 1200W', 'model' => 'TRM-3501R', 'price' => 5290, 'colors' => ['Red'], 'is_new' => true],
            ['name' => 'Tycoon Rice Cooker 3.5L Red 1200W', 'model' => 'TRM-3.5R', 'price' => 5590, 'colors' => ['Red'], 'is_new' => true],
            ['name' => 'Tycoon Multi Cooker 5.5L Maroon 1500W', 'model' => 'TCN-EMC-01', 'price' => 7990, 'colors' => ['Maroon'], 'is_new' => true],
            ['name' => 'Tycoon Multi Cooker 5.5L Maroon SS Pots 1500W', 'model' => 'TCN-EMC-01SS', 'price' => 7990, 'colors' => ['Maroon'], 'is_new' => true],
        ],

        // PRESSURE COOKERS
        'Pressure Cooker' => [
            ['name' => 'Tycoon Pressure Cooker 5.5L Queen White', 'model' => 'TCN-PC-5.5L', 'price' => 2400, 'colors' => ['White']],
            ['name' => 'Tycoon SS TRI PLY Pressure Cooker 6.5L', 'model' => 'TCN-PCSS-6E', 'price' => 4490, 'colors' => ['Silver'], 'is_new' => true],
        ],

        // MIXER GRINDERS
        'Mixer Grinder' => [
            ['name' => 'Tycoon Mixer Grinder 750W', 'model' => 'TMG-2401M', 'price' => 6990],
            ['name' => 'Tycoon Mixer Grinder 750W Jumbo Edition', 'model' => 'TMG-2501J', 'price' => 7150, 'is_new' => true],
            ['name' => 'Tycoon Mixer Grinder 1000W', 'model' => 'TMG-1000W', 'price' => 7500],
            ['name' => 'Tycoon Mixer Grinder 1500W Ninja Edition', 'model' => 'TMG-2601N', 'price' => 7990, 'is_new' => true],
            ['name' => 'Tycoon Mixer Grinder 1500W Samurai Edition', 'model' => 'TMG-26015', 'price' => 8990, 'is_new' => true],
        ],

        // COOKWARE
        'Cookware' => [
            ['name' => 'Tycoon 7 Pieces Non-Stick Cookware Set Gravity Gray', 'model' => 'TCN-NSC-2401GG', 'price' => 4800, 'colors' => ['Gray']],
            ['name' => 'Tycoon SS Honey Comb Fry Pan with Glass Lid 28cm', 'model' => 'TCN-SSFP-01', 'price' => 3990, 'is_new' => true],
            ['name' => 'Tycoon SS Honey Comb Wok Pan with Glass Lid 28cm', 'model' => 'TCN-SSWP-01', 'price' => 4490, 'is_new' => true],
            ['name' => 'Tycoon SS Soup Bowl with SS Lid Set 3 Pcs', 'model' => 'TCN-SSSB-01', 'price' => 4990, 'is_new' => true],
            ['name' => 'Tycoon SS Haman Dista with Silicon Lid', 'model' => 'TCN-HM01', 'price' => 2490, 'is_new' => true],
            ['name' => 'Tycoon SS Kitchen Rack with Glass & Spoon Holders', 'model' => 'TCN-SSKR-01', 'price' => 6990, 'is_new' => true],
        ],

        // ELECTRIC KETTLES
        '1.8L Electric Kettle' => [
            ['name' => 'Tycoon Electric Kettle 1.8L SS Body', 'model' => 'TCN-EKSS-2401', 'price' => 1490],
        ],
        '2.0L Electric Kettle' => [
            ['name' => 'Tycoon Electric Kettle 2.0L', 'model' => 'TCN-EK-2S', 'price' => 1490, 'is_new' => true],
        ],
        '3.0L Electric Kettle' => [
            ['name' => 'Tycoon Electric Kettle 3.0L', 'model' => 'TCN-EK-2501', 'price' => 2490, 'is_new' => true],
        ],

        // ELECTRIC COOKERS
        'Induction Cooker' => [
            ['name' => 'Tycoon Induction Cooker', 'model' => 'TCN-IND-24A', 'price' => 6060],
            ['name' => 'Tycoon Induction Cooker Standard', 'model' => 'TCN-IND-2401', 'price' => 5580],
        ],
        'Inverter Induction' => [
            ['name' => 'Tycoon Induction Cooker Inverter', 'model' => 'TCN-IND-26A', 'price' => 6490, 'is_new' => true],
            ['name' => 'Tycoon Induction Cooker Inverter Technology', 'model' => 'TCN-IND-2601', 'price' => 6490, 'is_new' => true],
        ],
        'Infrared Cooker' => [
            ['name' => 'Tycoon Infrared Cooker', 'model' => 'TCN-INF-24A', 'price' => 5870],
            ['name' => 'Tycoon Infrared Cooker Standard', 'model' => 'TCN-INF-2401', 'price' => 6280],
        ],
        'Inverter Infrared' => [
            ['name' => 'Tycoon Infrared Cooker Inverter', 'model' => 'TCN-INF-25SS', 'price' => 6490, 'is_new' => true],
        ],

        // CEILING FANS
        'Ceiling Fan 56 inch' => [
            ['name' => 'Tycoon Ceiling Fan 56" Marquise Golden', 'model' => 'Marquise', 'price' => 5600, 'colors' => ['Golden']],
            ['name' => 'Tycoon Ceiling Fan 56" Marquise Golden Off White', 'model' => 'Marquise', 'price' => 5500, 'colors' => ['Golden', 'Off White']],
            ['name' => 'Tycoon Ceiling Fan 56" Marquise Blue Off White', 'model' => 'Marquise', 'price' => 5500, 'colors' => ['Blue', 'Off White']],
            ['name' => 'Tycoon Ceiling Fan 56" Marquise Blue Silver', 'model' => 'Marquise', 'price' => 5600, 'colors' => ['Blue', 'Silver']],
            ['name' => 'Tycoon Ceiling Fan 56" Dynamic Blue Off White', 'model' => 'Dynamic', 'price' => 4800, 'colors' => ['Blue', 'Off White']],
            ['name' => 'Tycoon Ceiling Fan 56" Dynamic Golden Off White', 'model' => 'Dynamic', 'price' => 4800, 'colors' => ['Golden', 'Off White']],
            ['name' => 'Tycoon Ceiling Fan 56" Dynamic Off White', 'model' => 'Dynamic', 'price' => 4800, 'colors' => ['Off White']],
            ['name' => 'Tycoon Ceiling Fan 56" Dynamic White', 'model' => 'Dynamic', 'price' => 4800, 'colors' => ['White']],
        ],
        'Rechargeable Fan' => [
            ['name' => 'Rechargeable Fan 16T Touch Panel', 'model' => 'RF16TTP', 'price' => 6500],
        ],

        // GAS STOVE (No children - direct products)
        'Gas Stove' => [
            ['name' => 'Tycoon Double Burner Glass LPG Stove Fantasy Flower', 'model' => 'TCN-DBLPGG-Fantasy Flower', 'price' => 7140],
            ['name' => 'Tycoon Double Burner Glass LPG Stove Red Lily', 'model' => 'TCN-DBLPGG-Red Lily', 'price' => 7140],
            ['name' => 'Tycoon Double Burner Glass LPG Stove Magic Leaf', 'model' => 'TCN-DBLPGG-Magic Leaf', 'price' => 7140],
        ],

        // ROOM COMFORTER (No children)
        'Room Comforter' => [
            ['name' => 'Tycoon Room Comforter 1500W Self Rotation', 'model' => 'TCN-FIRE-2401', 'price' => 4390],
        ],

        // MICROWAVE OVEN (No children)
        'Microwave Oven' => [
            ['name' => 'Tycoon Microwave Oven Convection 30L', 'model' => 'TCN-MOC-30L', 'price' => 26140],
        ],

        // AIR CONDITIONER (No children)
        'Air Conditioner' => [
            ['name' => 'Tycoon AC 1.5 Ton 18K Hot & Cool Inverter WiFi', 'model' => 'TCN 18K HC R410 INV WiFi', 'price' => 85900],
        ],

        // LED TV
        '32 inch LED TV' => [
            ['name' => 'Tycoon 32" Frameless Voice Control Google LED TV', 'model' => 'TCN32GVV3', 'price' => 32900],
            ['name' => 'Tycoon 32" Frameless Voice Control Google Q-LED TV', 'model' => 'TCN32GQ1', 'price' => 33900, 'is_new' => true],
        ],
        '43 inch LED TV' => [
            ['name' => 'Tycoon 43" Frameless Voice Control Google LED TV', 'model' => 'TCN43VISIONGV1', 'price' => 47900],
            ['name' => 'Tycoon 43" Frameless Voice Control Android LED TV', 'model' => 'TCN43AV1', 'price' => 43900, 'is_new' => true],
        ],

        // WASHING MACHINE (No children)
        'Washing Machine' => [
            ['name' => 'Tycoon Washing Machine 8.0 KG Top Loading', 'model' => 'TCN-WM8A', 'price' => 41900, 'is_new' => true],
        ],

        // REFRIGERATORS
        '202L Refrigerator' => [
            ['name' => 'Tycoon-A 202 Magic Lotus', 'model' => 'TCN-A3DML-202', 'price' => 43900],
            ['name' => 'Tycoon-A 202 Lilium White Star', 'model' => 'TCN-A3DLW-202', 'price' => 43900],
            ['name' => 'Tycoon-A 202 Royal Red Daisy', 'model' => 'TCN-A3DRD-202', 'price' => 43900],
            ['name' => 'Tycoon-A 202 Magic Iris', 'model' => 'TCN-A3DMI-202', 'price' => 43900],
            ['name' => 'Tycoon-A 202 Black Peony', 'model' => 'TCN-A3DBP-202', 'price' => 43900],
        ],
        '235L Refrigerator' => [
            ['name' => 'Tycoon-A 235 Phoneky Cosmos', 'model' => 'TCN-A3DPC-235', 'price' => 48900],
            ['name' => 'Tycoon-A 235 Purple Magic Leaf', 'model' => 'TCN-A3DPML-235', 'price' => 48900],
            ['name' => 'Tycoon-A 235 Magic Hibiscus', 'model' => 'TCN-A3DMH-235', 'price' => 48900],
            ['name' => 'Tycoon-A 235 Fantasy Lotus', 'model' => 'TCN-A3DFL-235', 'price' => 48900],
            ['name' => 'Tycoon-A 235 Fantasy Cyclamen', 'model' => 'TCN-A3DFC-235', 'price' => 48900],
            ['name' => 'Tycoon-A 235 Red Poppy', 'model' => 'TCN-A3DRP-235', 'price' => 48900, 'is_new' => true],
        ],
        '252L Refrigerator' => [
            ['name' => 'Tycoon-A 252 Purple Magic Leaf', 'model' => 'TCN-A3DPML-252', 'price' => 49900],
            ['name' => 'Tycoon-A 252 Marble Deffodil', 'model' => 'TCN-A3DMD-252', 'price' => 49900],
            ['name' => 'Tycoon-A 252 Fantasy Cyclamen', 'model' => 'TCN-A3DFC-252', 'price' => 49900],
            ['name' => 'Tycoon-A 252 Pink Lotus', 'model' => 'TCN-A3DPL-252', 'price' => 49900],
            ['name' => 'Tycoon-A 252 Magic White Orchid', 'model' => 'TCN-A3DMWO-252', 'price' => 49900],
            ['name' => 'Tycoon-A 252 Magnolia', 'model' => 'TCN-A3DM-252', 'price' => 49900, 'is_new' => true],
        ],
        '302L Refrigerator' => [
            ['name' => 'Tycoon-A 302 Fantasy Gardenia', 'model' => 'TCN-A3DFG-302', 'price' => 52900],
            ['name' => 'Tycoon-A 302 Supreme Thunder', 'model' => 'TCN-A3DST-302', 'price' => 52900],
            ['name' => 'Tycoon-A 302 Fantasy Cyclamen', 'model' => 'TCN-A3DFC-302', 'price' => 52900],
            ['name' => 'Tycoon-A 302 Purple Magic Leaf', 'model' => 'TCN-A3DPML-302', 'price' => 52900],
            ['name' => 'Tycoon-A 302 Black Gardenia', 'model' => 'TCN-A3DBG-302', 'price' => 52900],
            ['name' => 'Tycoon-A 302 Magic Lilly', 'model' => 'TCN-A3DML-302', 'price' => 52900, 'is_new' => true],
            ['name' => 'Tycoon-A 302 Golden Lotus', 'model' => 'TCN-A3DGL-302', 'price' => 52900, 'is_new' => true],
        ],
        'Bottom Mount Refrigerator' => [
            ['name' => 'Tycoon-A 200 Purple Hibiscuss Bottom Mount', 'model' => 'TCN-200-BM-DPH', 'price' => 44900, 'is_new' => true],
            ['name' => 'Tycoon-A 200 Crimson Bloom Bottom Mount', 'model' => 'TCN-200-BM-DCB', 'price' => 44900, 'is_new' => true],
            ['name' => 'Tycoon-A 200 Artistic Jasmine Bottom Mount', 'model' => 'TCN-200-BM-DAJ', 'price' => 44900, 'is_new' => true],
            ['name' => 'Tycoon-A 200 Blue Poppy Bottom Mount', 'model' => 'TCN-200-BM-DBP', 'price' => 44900, 'is_new' => true],
            ['name' => 'Tycoon-A 200 Black Mirror Bottom Mount', 'model' => 'TCN-200-BM-BM', 'price' => 45490, 'is_new' => true],
        ],
    ];

    /**
     * Warranty configuration by category
     */
    private $warrantyConfig = [
        'Rice Cooker' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Pressure Cooker' => ['duration' => 1, 'unit' => 'years', 'type' => 'replacement'],
        'Mixer Grinder' => ['duration' => 2, 'unit' => 'years', 'type' => 'parts'],
        'Cookware' => ['duration' => 6, 'unit' => 'months', 'type' => 'replacement'],
        'Electric Kettle' => ['duration' => 6, 'unit' => 'months', 'type' => 'service'],
        'Electric Cooker' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Fan' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Gas Stove' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Room Comforter' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Microwave Oven' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Air Conditioner' => ['duration' => 5, 'unit' => 'years', 'type' => 'replacement'],
        'LED TV' => ['duration' => 1, 'unit' => 'years', 'type' => 'service'],
        'Washing Machine' => ['duration' => 2, 'unit' => 'years', 'type' => 'replacement'],
        'Refrigerator' => ['duration' => 2, 'unit' => 'years', 'type' => 'replacement'],
    ];

    public function run(): void
    {
        // Get vendor (first admin user)
        $vendor = User::role('admin')->first() ?? User::first();

        if (!$vendor) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        // Get or create brand
        $brand = Brand::firstOrCreate(
            ['slug' => 'tycoon'],
            [
                'name_en' => 'TYCOON',
                'name_bn' => 'টাইকুন',
                'description_en' => 'Premium home appliances and electronics brand',
                'description_bn' => 'প্রিমিয়াম হোম অ্যাপ্লায়েন্সেস এবং ইলেকট্রনিক্স ব্র্যান্ড',
                'is_active' => true,
            ]
        );

        $productsCreated = 0;

        foreach ($this->products as $categoryName => $products) {
            // Find category by name_en
            $category = Category::where('name_en', $categoryName)->first();

            if (!$category) {
                $this->command->warn("⚠ Category not found: {$categoryName}");
                continue;
            }

            // Get parent category name for warranty
            $parentCategory = $category->parent ?? $category;
            $rootCategory = $parentCategory->parent ?? $parentCategory;
            $rootName = $rootCategory->name_en;

            $warranty = $this->warrantyConfig[$rootName] ?? ['duration' => 1, 'unit' => 'years', 'type' => 'service'];

            // Create products
            foreach ($products as $productData) {
                $this->createProduct($productData, $category, $brand, $vendor, $warranty);
                $productsCreated++;
            }
        }

        $this->command->info('✅ Products seeded successfully!');
        $this->command->info("📦 Total products created: {$productsCreated}");
        $this->command->info('🏷 Featured products: ' . Product::where('is_featured', true)->count());
        $this->command->info('🔥 New products: ' . Product::where('is_new', true)->count());
        $this->command->info('📈 Active products: ' . Product::where('status', 'active')->count());
    }

    private function createProduct($data, $category, $brand, $vendor, $warranty)
    {
        $price = $data['price'];
        $comparePrice = $price * 1.15; // 15% higher
        $discountPercentage = rand(0, 15);
        $quantity = rand(20, 100);
        $isNew = $data['is_new'] ?? false;
        $isFeatured = rand(0, 10) > 7; // 30% chance
        $isBestseller = rand(0, 10) > 8; // 20% chance

        // Bengali translation
        $nameBn = $this->translateToBangla($data['name']);

        // Generate specifications
        $specifications = $this->generateSpecifications($data, $category);

        Product::create([
            'name_en' => $data['name'],
            'name_bn' => $nameBn,
            'short_description_en' => $this->generateShortDescription($data['name']),
            'short_description_bn' => $this->generateShortDescriptionBn($nameBn),
            'description_en' => $this->generateDescription($data['name'], $category),
            'description_bn' => $this->generateDescriptionBn($nameBn, $category),
            'meta_title_en' => $data['name'] . ' - Buy Online',
            'meta_description_en' => 'Buy ' . $data['name'] . ' online at best price in Bangladesh.',
            'meta_title_bn' => $nameBn . ' - অনলাইনে কিনুন',
            'meta_description_bn' => 'বাংলাদেশে সেরা মূল্যে ' . $nameBn . ' অনলাইনে কিনুন।',

            'price' => $price,
            'compare_price' => $comparePrice,
            'cost_price' => $price * 0.7,
            'discount_percentage' => $discountPercentage,

            'quantity' => $quantity,
            'alert_quantity' => 5,
            'track_quantity' => true,
            'stock_status' => $quantity > 0 ? 'in_stock' : 'out_of_stock',

            'model_number' => $data['model'],
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'warranty_duration' => $warranty['duration'],
            'warranty_unit' => $warranty['unit'],
            'warranty_type' => $warranty['type'],
            'specifications' => $specifications,

            'featured_images' => ['products/default-01.jpg'],
            'gallery_images' => ['products/default-01.jpg', 'products/default-02.jpg'],

            'weight' => rand(10, 50) / 10,
            'length' => rand(30, 100) / 10,
            'width' => rand(25, 80) / 10,
            'height' => rand(20, 70) / 10,

            'meta_keywords' => $this->generateKeywords($data['name']),

            'is_featured' => $isFeatured,
            'is_bestsells' => $isBestseller,
            'is_new' => $isNew,
            'status' => 'active',

            'average_rating' => rand(40, 50) / 10,
            'rating_count' => rand(10, 100),
            'total_sold' => rand(5, 150),
            'total_revenue' => $price * rand(5, 150),

            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'vendor_id' => $vendor->id,
        ]);
    }

    private function translateToBangla($name)
    {
        $translations = [
            'Tycoon' => 'টাইকুন',
            'Rice Cooker' => 'রাইস কুকার',
            'Multi Cooker' => 'মাল্টি কুকার',
            'Pressure Cooker' => 'প্রেসার কুকার',
            'Mixer Grinder' => 'মিক্সার গ্রাইন্ডার',
            'Electric Kettle' => 'ইলেকট্রিক কেটলি',
            'Induction Cooker' => 'ইন্ডাকশন কুকার',
            'Infrared Cooker' => 'ইনফ্রারেড কুকার',
            'Ceiling Fan' => 'সিলিং ফ্যান',
            'Rechargeable Fan' => 'রিচার্জেবল ফ্যান',
            'Gas Stove' => 'গ্যাস স্টোভ',
            'Room Comforter' => 'রুম কম্ফোর্টার',
            'Microwave Oven' => 'মাইক্রোওয়েভ ওভেন',
            'Air Conditioner' => 'এয়ার কন্ডিশনার',
            'LED TV' => 'এলইডি টিভি',
            'Washing Machine' => 'ওয়াশিং মেশিন',
            'Refrigerator' => 'রেফ্রিজারেটর',
            'Red' => 'লাল',
            'White' => 'সাদা',
            'Black' => 'কালো',
            'Blue' => 'নীল',
            'Silver' => 'রূপালী',
            'Golden' => 'সোনালী',
        ];

        $translated = $name;
        foreach ($translations as $en => $bn) {
            $translated = str_replace($en, $bn, $translated);
        }
        return $translated;
    }

    private function generateShortDescription($name)
    {
        return "Premium quality {$name} with excellent features and durability. Best price guaranteed with official warranty.";
    }

    private function generateShortDescriptionBn($name)
    {
        return "চমৎকার বৈশিষ্ট্য এবং স্থায়িত্ব সহ প্রিমিয়াম মানের {$name}।";
    }

    private function generateDescription($name, $category)
    {
        return "Premium quality {$name} from TYCOON brand. This product features advanced technology, durable construction, and comes with manufacturer warranty. Perfect for home and kitchen use. Get the best deals with fast delivery across Bangladesh.";
    }

    private function generateDescriptionBn($name, $category)
    {
        return "টাইকুন ব্র্যান্ডের প্রিমিয়াম মানের {$name}। এই পণ্যটিতে রয়েছে উন্নত প্রযুক্তি, টেকসই নির্মাণ এবং প্রস্তুতকারকের ওয়ারেন্টি। ঘর এবং রান্নাঘর ব্যবহারের জন্য উপযুক্ত।";
    }

    private function generateSpecifications($data, $category)
    {
        $specs = [];

        // Add colors if available
        if (isset($data['colors']) && !empty($data['colors'])) {
            $specs['Available Colors'] = implode(', ', $data['colors']);
        }

        // Add model
        $specs['Model Number'] = $data['model'];

        // Category-specific specs
        if (str_contains($category->name_en, 'Rice Cooker') || str_contains($category->name_en, 'Multi Cooker')) {
            $specs['Features'] = 'Auto Shut-off, Keep Warm Function, Non-stick Pot';
        } elseif (str_contains($category->name_en, 'Mixer Grinder')) {
            $specs['Features'] = 'Multiple Speed Control, Overload Protection, Stainless Steel Jars';
        } elseif (str_contains($category->name_en, 'Kettle')) {
            $specs['Features'] = 'Auto Shut-off, Boil Dry Protection, Cordless Design';
        } elseif (str_contains($category->name_en, 'Fan')) {
            $specs['Features'] = 'High Air Delivery, Energy Efficient, Silent Operation';
        } elseif (str_contains($category->name_en, 'Refrigerator')) {
            $specs['Features'] = '3D Cooling Technology, Energy Efficient, Decorative Design';
        } elseif (str_contains($category->name_en, 'TV')) {
            $specs['Features'] = 'Smart TV, Voice Control, Frameless Design';
        }

        return $specs;
    }

    private function generateKeywords($name)
    {
        return strtolower($name) . ', buy online, bangladesh, tycoon, best price, home appliances';
    }
}
