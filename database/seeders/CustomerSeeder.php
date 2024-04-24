<?php

namespace Database\Seeders;

use App\Models\Admin\Customer\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $customer = [
            [
                'name' => 'Raju',
                'phone' => 9988776655,
                'email' => 'raju@gmail.com',
            ],
            [
                'name' => 'Guru',
                'phone' => 1122334455,
                'email' => 'guru@gmail.com',
            ],
            [
                'name' => 'Senthil',
                'phone' => 5566774433,
                'email' => 'senthil@gmail.com',
            ],
            [
                'name' => 'Ramu',
                'phone' => 1133669900,
                'email' => 'ramu@gmail.com',
            ]];

        foreach ($customer as $row) {
            Customer::create($row);
        }
    }
}
