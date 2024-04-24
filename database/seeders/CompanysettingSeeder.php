<?php

namespace Database\Seeders;

use App\Models\Admin\Settings\Generalsettings\Companysetting;
use Illuminate\Database\Seeder;

class CompanysettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Companysetting::create([
            'companyfullname' => '8Queens',
            'companyshortname' => '8Queens',
            'address' => 'New No: 231, Old No: 112, 1st Floor, R.K.Mutt Road, Mandaveli, Chennai-600028',
            'phone' => '+91 4423 2265',
            'email' => 'vimalraj@8queens.com',
            'language' => 1,

            'logo' => '',
            'favicon' => '',
            'balance' => 0,
        ]);
    }
}
