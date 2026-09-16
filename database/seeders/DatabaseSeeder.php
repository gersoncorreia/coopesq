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
            SettingsSeeder::class,
            DifferentialsSeeder::class,
            CategoriesAndProductsSeeder::class,
            PartnersSeeder::class,
            HeroBannersSeeder::class,
            ContentSeeder::class,
        ]);
    }
}
