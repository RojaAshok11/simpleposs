<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Systemsettings\Timezonemaster;
use Illuminate\Database\Seeder;

class TimezonemasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $timezonemaster = [
            [
                'country_name' => 'India',
                'time_zone' => 'India Standard Time',
            ],
            [
                'country_name' => 'United States',
                'time_zone' => 'Mountain Standard Time',
            ],
            [
                'country_name' => 'United Kingdom',
                'time_zone' => 'GMT Standard Time',
            ],
            [
                'country_name' => 'North Korea',
                'time_zone' => 'Korea Standard Time',
            ],
            [
                'country_name' => 'Singapore',
                'time_zone' => 'Singapore Standard Time',
            ]];

        foreach ($timezonemaster as $row) {
            Timezonemaster::create($row);
        }
    }
}
