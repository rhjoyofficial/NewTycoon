<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Image mapping for categories
     */
    private $imageMapping = [
        'rice-cooker' => 'categories/rice-cooker.png',
        'pressure-cooker' => 'categories/pressure-cooker.png',
        'mixer-grinder' => 'categories/mixer.png',
        'cookware' => 'categories/cookware.png',
        'electric-kettle' => 'categories/kettle.png',
        'electric-cooker' => 'categories/induction.png',
        'ceiling-fan' => 'categories/fan.png',
        'rechargeable-fan' => 'categories/rechargeable-fan.png',
        'gas-stove' => 'categories/gas-burner.png',
        'room-comforter' => 'categories/comforter.png',
        'microwave-oven' => 'categories/microwave.png',
        'air-conditioner' => 'categories/ac.png',
        'led-tv' => 'categories/led-tv.png',
        'washing-machine' => 'categories/washing-machine.png',
        'refrigerator' => 'categories/refrigerator.png',
        'home-appliance' => 'categories/home-appliance.png',
        'kitchen-appliance' => 'categories/kitchen-appliance.png',
        'fan' => 'categories/fan.png',
        'gas-burner' => 'categories/gas-burner.png',
    ];

    public function run(): void
    {
        // Create ROOT CATEGORIES first

        // =============================================
        // ROOT CATEGORY 1: HOME APPLIANCE
        // =============================================
        $homeAppliance = Category::updateOrCreate(
            ['slug' => 'home-appliance'],
            [
                'name_en' => 'Home Appliance',
                'name_bn' => 'হোম অ্যাপ্লায়েন্স',
                'description_en' => 'Essential home appliances for modern living including fans, mixers, and more.',
                'description_bn' => 'আধুনিক জীবনের জন্য প্রয়োজনীয় হোম অ্যাপ্লায়েন্স including ফ্যান, মিক্সার এবং আরও অনেক কিছু।',
                'image' => 'categories/home-appliance.png',
                'parent_id' => null,
                'depth' => 1,
                'order' => 1,
                'nav_order' => 1,
                'show_in_nav' => true,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'Home Appliances - Best Products Online',
                'meta_description' => 'Shop for home appliances at best prices in Bangladesh.',
                'meta_keywords' => 'home appliances, fans, mixer grinder, home electronics',
            ]
        );

        // =============================================
        // ROOT CATEGORY 2: KITCHEN APPLIANCE
        // =============================================
        $kitchenAppliance = Category::updateOrCreate(
            ['slug' => 'kitchen-appliance'],
            [
                'name_en' => 'Kitchen Appliance',
                'name_bn' => 'কিচেন অ্যাপ্লায়েন্স',
                'description_en' => 'Modern kitchen appliances for efficient cooking including cookware, gas burners, pressure cookers, and rice cookers.',
                'description_bn' => 'দক্ষ রান্নার জন্য আধুনিক কিচেন অ্যাপ্লায়েন্স including কুকওয়্যার, গ্যাস বার্নার, প্রেসার কুকার এবং রাইস কুকার।',
                'image' => 'categories/kitchen-appliance.png',
                'parent_id' => null,
                'depth' => 1,
                'order' => 2,
                'nav_order' => 2,
                'show_in_nav' => true,
                'is_featured' => false,
                'is_active' => true,
                'meta_title' => 'Kitchen Appliances - Best Products Online',
                'meta_description' => 'Shop for kitchen appliances at best prices in Bangladesh.',
                'meta_keywords' => 'kitchen appliances, cookware, gas burner, pressure cooker, rice cooker',
            ]
        );

        $order = 3; // Start from 3 since we've used 1 and 2 for root categories

        // =============================================
        // HOME APPLIANCE CHILDREN
        // =============================================

        // Fan category under Home Appliance
        $fan = Category::updateOrCreate(
            ['slug' => 'fan'],
            [
                'name_en' => 'Fan',
                'name_bn' => 'ফ্যান',
                'description_en' => 'Decorative ceiling fans and rechargeable emergency fans with high air delivery and energy efficiency.',
                'description_bn' => 'উচ্চ বায়ু প্রবাহ এবং শক্তি দক্ষতা সহ ডেকোরেটিভ সিলিং ফ্যান এবং রিচার্জেবল ইমার্জেন্সি ফ্যান।',
                'image' => 'categories/fan.png',
                'parent_id' => $homeAppliance->id,
                'depth' => 2,
                'order' => 1,
                'nav_order' => 999,
                'show_in_nav' => false,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Fan - Best Products Online',
                'meta_description' => 'Shop for fans at best prices in Bangladesh.',
                'meta_keywords' => 'fan, ceiling fan, rechargeable fan',
            ]
        );

        // Fan child categories
        $fanChildren = [
            ['name' => 'Ceiling Fan 56 inch', 'bn_name' => '৫৬ ইঞ্চি সিলিং ফ্যান', 'slug' => 'ceiling-fan-56-inch'],
            ['name' => 'Rechargeable Fan', 'bn_name' => 'রিচার্জেবল ফ্যান', 'slug' => 'rechargeable-fan'],
        ];

        $childOrder = 1;
        foreach ($fanChildren as $child) {
            Category::updateOrCreate(
                [
                    'slug' => $child['slug'],
                    'parent_id' => $fan->id
                ],
                [
                    'name_en' => $child['name'],
                    'name_bn' => $child['bn_name'],
                    'description_en' => $this->getLeafDescription($child['name']),
                    'description_bn' => $this->translateDescription($this->getLeafDescription($child['name'])),
                    'image' => $this->imageMapping[$child['slug']] ?? $this->imageMapping['fan'] ?? 'categories/default.png',
                    'depth' => 3,
                    'order' => $childOrder++,
                    'show_in_nav' => false,
                    'is_featured' => false,
                    'is_active' => true,
                    'meta_title' => $child['name'] . ' - Buy Online',
                    'meta_description' => 'Buy ' . strtolower($child['name']) . ' at best price in Bangladesh.',
                ]
            );
        }


        // Mixer Grinder under Home Appliance
        $mixerGrinder = Category::updateOrCreate(
            ['slug' => 'mixer-grinder'],
            [
                'name_en' => 'Mixer Grinder',
                'name_bn' => 'মিক্সার গ্রাইন্ডার',
                'description_en' => 'Powerful mixer grinders with multiple jars and speeds ranging from 750W to 1500W for all kitchen grinding needs.',
                'description_bn' => 'সমস্ত রান্নার পেষার প্রয়োজনের জন্য ৭৫০W থেকে ১৫০০W পর্যন্ত একাধিক জার এবং গতি সহ শক্তিশালী মিক্সার গ্রাইন্ডার।',
                'image' => 'categories/mixer.png',
                'parent_id' => $homeAppliance->id,
                'depth' => 2,
                'order' => 2,
                'nav_order' => 3,
                'show_in_nav' => true,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Mixer Grinder - Best Products Online',
                'meta_description' => 'Shop for mixer grinders at best prices in Bangladesh.',
                'meta_keywords' => 'mixer grinder, blender, juicer mixer grinder',
            ]
        );

        // =============================================
        // KITCHEN APPLIANCE CHILDREN
        // =============================================

        // Cookware under Kitchen Appliance
        $cookware = Category::updateOrCreate(
            ['slug' => 'cookware'],
            [
                'name_en' => 'Cookware',
                'name_bn' => 'রান্নার পাত্র',
                'description_en' => 'Non-stick cookware sets and stainless steel pans, woks, soup bowls and kitchen accessories.',
                'description_bn' => 'নন-স্টিক কুকওয়্যার সেট এবং স্টেইনলেস স্টিলের প্যান, ওয়াক, স্যুপ বোল এবং রান্নাঘরের জিনিসপত্র।',
                'image' => 'categories/cookware.png',
                'parent_id' => $kitchenAppliance->id,
                'depth' => 2,
                'order' => 1,
                'nav_order' => 4,
                'show_in_nav' => true,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Cookware - Best Products Online',
                'meta_description' => 'Shop for cookware at best prices in Bangladesh.',
                'meta_keywords' => 'cookware, non-stick cookware, pans, woks',
            ]
        );

        // Gas Burner under Kitchen Appliance
        $gasBurner = Category::updateOrCreate(
            ['slug' => 'gas-burner'],
            [
                'name_en' => 'Gas Burner',
                'name_bn' => 'গ্যাস বার্নার',
                'description_en' => 'Double burner glass top LPG stoves with safety features, auto ignition and printed designs.',
                'description_bn' => 'নিরাপত্তা বৈশিষ্ট্য, অটো ইগনিশন এবং প্রিন্টেড ডিজাইন সহ ডাবল বার্নার গ্লাস টপ এলপিজি স্টোভ।',
                'image' => 'categories/gas-burner.png',
                'parent_id' => $kitchenAppliance->id,
                'depth' => 2,
                'order' => 2,
                'nav_order' => 999,
                'show_in_nav' => false,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Gas Burner - Best Products Online',
                'meta_description' => 'Shop for gas burners at best prices in Bangladesh.',
                'meta_keywords' => 'gas burner, gas stove, LPG stove',
            ]
        );

        // Pressure Cooker under Kitchen Appliance
        $pressureCooker = Category::updateOrCreate(
            ['slug' => 'pressure-cooker'],
            [
                'name_en' => 'Pressure Cooker',
                'name_bn' => 'প্রেসার কুকার',
                'description_en' => 'Aluminum and stainless steel pressure cookers with safety features for fast and efficient cooking.',
                'description_bn' => 'দ্রুত এবং দক্ষ রান্নার জন্য নিরাপত্তা বৈশিষ্ট্য সহ অ্যালুমিনিয়াম এবং স্টেইনলেস স্টিলের প্রেসার কুকার।',
                'image' => 'categories/pressure-cooker.png',
                'parent_id' => $kitchenAppliance->id,
                'depth' => 2,
                'order' => 3,
                'nav_order' => 2,
                'show_in_nav' => true,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Pressure Cooker - Best Products Online',
                'meta_description' => 'Shop for pressure cookers at best prices in Bangladesh.',
                'meta_keywords' => 'pressure cooker, aluminum pressure cooker, SS pressure cooker',
            ]
        );


        // Rice Cooker under Kitchen Appliance
        $riceCooker = Category::updateOrCreate(
            ['slug' => 'rice-cooker'],
            [
                'name_en' => 'Rice Cooker',
                'name_bn' => 'রাইস কুকার',
                'description_en' => 'Electric rice cookers and multi cookers with auto shut-off, keep warm function and non-stick pots for perfectly cooked rice.',
                'description_bn' => 'নিখুঁতভাবে রান্না করা চালের জন্য অটো শাট-অফ, গরম রাখার ফাংশন এবং নন-স্টিক পাত্র সহ ইলেকট্রিক রাইস কুকার এবং মাল্টি কুকার।',
                'image' => 'categories/rice-cooker.png',
                'parent_id' => $kitchenAppliance->id,
                'depth' => 2,
                'order' => 4,
                'nav_order' => 1,
                'show_in_nav' => true,
                'is_featured' => true,
                'is_active' => true,
                'meta_title' => 'Rice Cooker - Best Products Online',
                'meta_description' => 'Shop for rice cookers at best prices in Bangladesh.',
                'meta_keywords' => 'rice cooker, multi cooker, electric rice cooker',
            ]
        );

        // =============================================
        // REMAINING CATEGORIES (Unchanged from original)
        // These will be Level 1 categories without a parent
        // =============================================

        $remainingCategories = [
            // =============================================
            // FEATURED CATEGORY: ELECTRIC KETTLE
            // =============================================
            'Electric Kettle' => [
                'bn_name' => 'ইলেকট্রিক কেটলি',
                'show_in_nav' => true,
                'is_featured' => true,
                'nav_order' => 5,
                'description' => 'Stainless steel electric kettles with auto shut-off, boil-dry protection and fast heating from 1.8L to 3.0L capacity.',
                'children' => [
                    ['name' => '1.8L Electric Kettle', 'bn_name' => '১.৮ লিটার কেটলি', 'slug' => '1.8l-electric-kettle'],
                    ['name' => '2.0L Electric Kettle', 'bn_name' => '২.০ লিটার কেটলি', 'slug' => '2.0l-electric-kettle'],
                    ['name' => '3.0L Electric Kettle', 'bn_name' => '৩.০ লিটার কেটলি', 'slug' => '3.0l-electric-kettle'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: ELECTRIC COOKER
            // =============================================
            'Electric Cooker' => [
                'bn_name' => 'ইলেকট্রিক কুকার',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Induction and infrared cookers with standard and inverter technology for efficient and fast cooking.',
                'children' => [
                    ['name' => 'Induction Cooker', 'bn_name' => 'ইন্ডাকশন কুকার', 'slug' => 'induction-cooker'],
                    ['name' => 'Inverter Induction', 'bn_name' => 'ইনভার্টার ইন্ডাকশন', 'slug' => 'inverter-induction'],
                    ['name' => 'Infrared Cooker', 'bn_name' => 'ইনফ্রারেড কুকার', 'slug' => 'infrared-cooker'],
                    ['name' => 'Inverter Infrared', 'bn_name' => 'ইনভার্টার ইনফ্রারেড', 'slug' => 'inverter-infrared'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: GAS STOVE (as single category)
            // =============================================
            'Gas Stove' => [
                'bn_name' => 'গ্যাস স্টোভ',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Double burner glass top LPG stoves with safety features, auto ignition and printed designs.',
                'has_children' => false,
            ],

            // =============================================
            // FEATURED CATEGORY: ROOM COMFORTER
            // =============================================
            'Room Comforter' => [
                'bn_name' => 'রুম কম্ফোর্টার',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Electric room heaters for winter comfort with self-rotation feature and safety protection.',
                'has_children' => false,
            ],

            // =============================================
            // FEATURED CATEGORY: MICROWAVE OVEN
            // =============================================
            'Microwave Oven' => [
                'bn_name' => 'মাইক্রোওয়েভ ওভেন',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Convection microwave ovens 30L with multi-cooking functions for baking, grilling and heating.',
                'has_children' => false,
            ],

            // =============================================
            // FEATURED CATEGORY: AIR CONDITIONER
            // =============================================
            'Air Conditioner' => [
                'bn_name' => 'এয়ার কন্ডিশনার',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Energy efficient inverter air conditioners with hot & cool function and WiFi smart control.',
                'has_children' => false,
            ],

            // =============================================
            // FEATURED CATEGORY: LED TV
            // =============================================
            'LED TV' => [
                'bn_name' => 'এলইডি টিভি',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Frameless smart LED TVs with voice control, Google OS, Android OS and built-in streaming apps.',
                'children' => [
                    ['name' => '32 inch LED TV', 'bn_name' => '৩২ ইঞ্চি এলইডি টিভি', 'slug' => '32-inch-led-tv'],
                    ['name' => '43 inch LED TV', 'bn_name' => '৪৩ ইঞ্চি এলইডি টিভি', 'slug' => '43-inch-led-tv'],
                ]
            ],

            // =============================================
            // FEATURED CATEGORY: WASHING MACHINE
            // =============================================
            'Washing Machine' => [
                'bn_name' => 'ওয়াশিং মেশিন',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Fully automatic top loading washing machines 8KG with multiple wash programs and energy efficiency.',
                'has_children' => false,
            ],

            // =============================================
            // FEATURED CATEGORY: REFRIGERATOR
            // =============================================
            'Refrigerator' => [
                'bn_name' => 'রেফ্রিজারেটর',
                'show_in_nav' => false,
                'is_featured' => true,
                'nav_order' => 999,
                'description' => 'Direct cool and bottom mount refrigerators with 3D cooling technology and decorative printed designs.',
                'children' => [
                    ['name' => '202L Refrigerator', 'bn_name' => '২০২ লিটার রেফ্রিজারেটর', 'slug' => '202l-refrigerator'],
                    ['name' => '235L Refrigerator', 'bn_name' => '২৩৫ লিটার রেফ্রিজারেটর', 'slug' => '235l-refrigerator'],
                    ['name' => '252L Refrigerator', 'bn_name' => '২৫২ লিটার রেফ্রিজারেটর', 'slug' => '252l-refrigerator'],
                    ['name' => '302L Refrigerator', 'bn_name' => '৩০২ লিটার রেফ্রিজারেটর', 'slug' => '302l-refrigerator'],
                    ['name' => 'Bottom Mount Refrigerator', 'bn_name' => 'বটম মাউন্ট রেফ্রিজারেটর', 'slug' => 'bottom-mount-refrigerator'],
                ]
            ],
        ];

        foreach ($remainingCategories as $name => $data) {
            $slug = Str::slug($name);
            $bnName = $data['bn_name'] ?? '';
            $showInNav = $data['show_in_nav'] ?? false;
            $isFeatured = $data['is_featured'] ?? false;
            $navOrder = $data['nav_order'] ?? 999;
            $description = $data['description'] ?? '';
            $hasChildren = $data['has_children'] ?? true;

            // Create main category (Level 1) - no parent
            $mainCategory = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name_en' => $name,
                    'name_bn' => $bnName,
                    'description_en' => $description,
                    'description_bn' => $this->translateDescription($description),
                    'image' => $this->imageMapping[$slug] ?? 'categories/default.png',
                    'parent_id' => null,
                    'depth' => 1,
                    'order' => $order++,
                    'nav_order' => $navOrder,
                    'show_in_nav' => $showInNav,
                    'is_featured' => $isFeatured,
                    'is_active' => true,
                    'meta_title' => $name . ' - Best Products Online',
                    'meta_description' => 'Shop for ' . strtolower($name) . ' at best prices in Bangladesh.',
                    'meta_keywords' => $this->generateKeywords($name),
                ]
            );

            // Create Level 2 categories (LEAF NODES) if has children
            if ($hasChildren && isset($data['children']) && is_array($data['children'])) {
                $childOrder = 1;
                foreach ($data['children'] as $child) {
                    $childName = $child['name'];
                    $childBnName = $child['bn_name'] ?? '';
                    $childSlug = $child['slug'] ?? Str::slug($childName);

                    Category::updateOrCreate(
                        [
                            'slug' => $childSlug,
                            'parent_id' => $mainCategory->id
                        ],
                        [
                            'name_en' => $childName,
                            'name_bn' => $childBnName,
                            'description_en' => $this->getLeafDescription($childName),
                            'description_bn' => $this->translateDescription($this->getLeafDescription($childName)),
                            'image' => $this->imageMapping[$childSlug] ?? $this->imageMapping[$slug] ?? 'categories/default.png',
                            'depth' => 2,
                            'order' => $childOrder++,
                            'show_in_nav' => false,
                            'is_featured' => false,
                            'is_active' => true,
                            'meta_title' => $childName . ' - Buy Online',
                            'meta_description' => 'Buy ' . strtolower($childName) . ' at best price in Bangladesh.',
                        ]
                    );
                }
            }
        }

        $this->command->info('✅ Categories seeded successfully!');
        $this->command->info('📁 Total categories: ' . Category::count());
        $this->command->info('📁 Level 1 (Parent): ' . Category::whereNull('parent_id')->count());
        $this->command->info('📁 Level 2: ' . Category::where('depth', 2)->count());
        $this->command->info('📁 Level 3 (Leaf): ' . Category::where('depth', 3)->count());
        $this->command->info('⭐ Featured categories: ' . Category::where('is_featured', true)->count());
        $this->command->info('🧭 Navigation categories: ' . Category::where('show_in_nav', true)->count());
    }

    private function getLeafDescription(string $name): string
    {
        return "High quality {$name} with warranty and fast delivery across Bangladesh at competitive prices.";
    }

    private function translateDescription(string $text): string
    {
        $translations = [
            'High quality' => 'উচ্চ মানের',
            'with' => 'সহ',
            'and' => 'এবং',
            'Electric' => 'ইলেকট্রিক',
            'Stainless steel' => 'স্টেইনলেস স্টিল',
            'Fan' => 'ফ্যান',
            'Mixer Grinder' => 'মিক্সার গ্রাইন্ডার',
            'Cookware' => 'কুকওয়্যার',
            'Gas Burner' => 'গ্যাস বার্নার',
            'Pressure Cooker' => 'প্রেসার কুকার',
            'Rice Cooker' => 'রাইস কুকার',
            'Home Appliance' => 'হোম অ্যাপ্লায়েন্স',
            'Kitchen Appliance' => 'কিচেন অ্যাপ্লায়েন্স',
        ];

        $translated = $text;
        foreach ($translations as $en => $bn) {
            $translated = str_replace($en, $bn, $translated);
        }
        return $translated;
    }

    private function generateKeywords(string $name): string
    {
        $base = strtolower($name);
        return "{$base}, buy {$base}, {$base} price bangladesh, best {$base}, {$base} online";
    }
}
