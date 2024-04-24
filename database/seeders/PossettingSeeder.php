<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Pos\Possetting;
use Illuminate\Database\Seeder;

class PossettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Possetting::create([
            'theme' => 3,
            'pos_position' => 2,
            'date_format' => 1,
            'time_type' => 1,
            'language' => 'en',

            'carticon' => '',
        ]);
    }
}
