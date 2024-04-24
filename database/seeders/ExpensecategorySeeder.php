<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use Illuminate\Database\Seeder;

class ExpensecategorySeeder extends Seeder
{

    public function run()
    {
        $expensecategory = [
            [
                'name' => 'Rent',
            ],
            [
                'name' => 'Electricity',
            ]];

        foreach ($expensecategory as $row) {
            Expensecategory::create($row);
        }
    }
}
