<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Systemsettings\Currencymaster;
use Illuminate\Database\Seeder;

class CurrencymasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $currencymaster = [
            [
                'country_name' => 'India',
                'currency_name' => 'Indian Rupee',
                'currency' => '₹',
                'is_default' => true,
            ],
            [
                'country_name' => 'United States',
                'currency_name' => 'United States Dollar',
                'currency' => '$',
                'is_default' => false,
            ],
            [
                'country_name' => 'United Kingdom',
                'currency_name' => 'British Pound',
                'currency' => '£',
                'is_default' => false,
            ],
            [
                'country_name' => 'South Korea',
                'currency_name' => 'South Korean Won',
                'currency' => '₩',
                'is_default' => false,
            ],
            [
                'country_name' => 'kuwait',
                'currency_name' => 'Kuwaiti Dinar',
                'currency' => 'ك',
                'is_default' => false,
            ]];

        foreach ($currencymaster as $row) {
            Currencymaster::create($row);
        }
    }
}
