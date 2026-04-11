<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            CategorySeeder::class,
            // BrandSeeder::class,
            UserSeeder::class,
            UserProfileSeeder::class,
            ProductSeeder::class,
            // OrderSeeder::class,
            // CartSeeder::class,
            // ReviewSeeder::class,
            FooterSeeder::class,
            OfferSeeder::class,
            HeroSlideSeeder::class,
            SectionSeeder::class,
            CatalogSeeder::class,
        ]);
    }
}
