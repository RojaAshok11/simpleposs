<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Location\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $state = [
            [
                'id' => 1,
                'name' => 'NEW DELHI',
            ],
            [
                'id' => 2,
                'name' => 'UTTAR PRADESH',
            ],
            [
                'id' => 3,
                'name' => 'HARYANA',
            ],
            [
                'id' => 4,
                'name' => 'PUNJAB',
            ],
            [
                'id' => 5,
                'name' => 'RAJASTAN',
            ],
            [
                'id' => 6,
                'name' => 'WEST BENGAL',
            ],
            [
                'id' => 7,
                'name' => 'ORISSA',
            ],
            [
                'id' => 8,
                'name' => 'BIHAR',
            ],
            [
                'id' => 9,
                'name' => 'JHARKAND',
            ],
            [
                'id' => 10,
                'name' => 'MAHARASTRA',
            ],
            [
                'id' => 11,
                'name' => 'GUJARAT',
            ],
            [
                'id' => 12,
                'name' => 'Madhya Pradesh',
            ],
            [
                'id' => 13,
                'name' => 'CHATTISGARH',
            ],
            [
                'id' => 14,
                'name' => 'TAMILNADU',
            ],
            [
                'id' => 15,
                'name' => 'KERALA',
            ],
            [
                'id' => 16,
                'name' => 'TELANAGAN',
            ],
            [
                'id' => 17,
                'name' => 'ANDHRA PRADESH',
            ],
            [
                'id' => 18,
                'name' => 'KARNATAKA',
            ],
        ];

        foreach ($state as $row) {
            State::create($row);
        }
    }
}
