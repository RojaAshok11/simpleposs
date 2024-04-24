<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Mastersettings\Uom;
use Illuminate\Database\Seeder;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['name' => 'Kg'],
            ['name' => 'Litre'],
            ['name' => 'Meter'],
        ] as $row) {
            Uom::create($row);
        }
    }
}
