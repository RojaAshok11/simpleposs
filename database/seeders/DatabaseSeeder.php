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
            UserSeeder::class,
            ThemesettingSeeder::class,
            CompanysettingSeeder::class,
            CitySeeder::class,
            StateSeeder::class,
            ProductcategorySeeder::class,
            CustomerSeeder::class,
            ExpensecategorySeeder::class,
            ProductSeeder::class,
            SupplierSeeder::class,
            UomSeeder::class,
            PossettingSeeder::class,
            CurrencymasterSeeder::class,
            TimezonemasterSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
