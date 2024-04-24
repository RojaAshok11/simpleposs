<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Admin\Supplier\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $supplier = [
            [
                'name' => 'John Smith',
                'phone' => 9988776655,
                'email' => 'johnsmith@gmail.com',
                'gst'=> '07AAAAA0000A1Z8',
                'pan' => 'AEYPM5403H',
                'cpname' => 'Smith Adam',
                'cpphone'=> '1234567890',
                'cpmail' => 'silverstone@gmail.com',
                'address' => 'Chennai',
            ],
            [
                'name' => 'Kane Williamson',
                'phone' => 9988776654,
                'email' => 'kanewilliamson@gmail.com',
                'gst'=> '05BCDAW0000A1Z8',
                'pan' => 'ABYPM5903Z',
                'cpname' => 'Hardik',
                'cpphone'=> '1234567891',
                'cpmail' => 'wellsfargo@gmail.com',
                'address' => 'Pondicherry',
            ],
            [
                'name' => 'Will Smith',
                'phone' => 7988776654,
                'email' => 'willsmith@gmail.com',
                'gst'=> '09AABCQ0000B1Z8',
                'pan' => 'DEYPM5904Z',
                'cpname' => 'Jaden Smith',
                'cpphone'=> '1274567891',
                'cpmail' => 'wetrade@gmail.com',
                'address' => 'Madurai',
            ],
            [
                'name' => 'Keanu Reeves',
                'phone' => 9968776654,
                'email' => 'keanureeves@gmail.com',
                'gst'=> '09AABCQ0000K1Y8',
                'pan' => 'KERPM5904Z',
                'cpname' => 'John Doe',
                'cpphone'=> '9174567891',
                'cpmail' => 'perfectsolution@gmail.com',
                'address' => 'Kerala',
            ]
        ];

        foreach ($supplier as $row) {
            Supplier::create($row);
        }
    }
}
