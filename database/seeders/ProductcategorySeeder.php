<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Mastersettings\Productcategory;
use Illuminate\Database\Seeder;

class ProductcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $category = [
            [
                'name' => 'Fruits',
                'active' => true,
            ],
            [
                'name' => 'Milk',
                'active' => true,
            ],
            [
                'name' => 'Meat',
                'active' => true,
            ],
            [
                'name' => 'Vegetables',
                'active' => true,
            ],
            [
                'name' => 'Groceries',
                'active' => true,
            ],

        ];

        foreach ($category as $row) {
            Productcategory::create($row);
        }
    }
}
