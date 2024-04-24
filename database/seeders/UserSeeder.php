<?php

namespace Database\Seeders;

use App\Models\Admin\Auth\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            [
                'name' => 'ADMIN',
                'email' => 'admin@gmail.com',
                'phone' => '1234567890',
                'password' => '12345678',
                'role_id' => 1,
            ],
        ] as $row) {
            User::create($row);
        }
    }
}
