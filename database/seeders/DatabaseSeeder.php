<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
            // CustomerSeeder::class,
            // CategorySeeder::class,
            // SubcategorySeeder::class,
            // BrandSeeder::class,
            // CategoryBrandSeeder::class,
            // SeoSeeder::class,
            // SmtpSeeder::class,
            // PageSeeder::class,
            // SettingSeeder::class,
            // WarehouseSeeder::class,
            CouponSeeder::class,
        ]);
    }
}
