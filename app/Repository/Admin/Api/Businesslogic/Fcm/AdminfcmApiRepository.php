<?php

namespace App\Repository\Admin\Api\Businesslogic\Fcm;

use App\Models\Admin\Auth\Deviceinfo;
use App\Repository\Admin\Api\Interfacelayer\Fcm\IAdminfcmApiRepository;

class AdminfcmApiRepository implements IAdminfcmApiRepository
{
    public function adminsavedeviceinfo()
    {
        auth()->user()
            ->deviceinfo()
            ->create([
                'device_token' => request('device_token'),
                'device_model' => request('device_model'),
                'device_brand' => request('device_brand'),
                'device_manufacturer' => request('device_manufacturer'),

                'computer_name' => request('computer_name'),

                'no_of_cores' => request('no_of_cores'),
                'user_name' => request('user_name'),
                'editionid' => request('editionid'),
                'productid' => request('productid'),
                'product_name' => request('product_name'),
                'register_owner' => request('register_owner'),
                'deviceid' => request('deviceid'),

                'host_name' => request('host_name'),
                'arch' => request('arch'),
                'kernel_version' => request('kernel_version'),
                'major_version' => request('major_version'),
                'minor_version' => request('minor_version'),
                'patch_version' => request('patch_version'),
                'os_release' => request('os_release'),
                'active_cpus' => request('active_cpus'),
                'memory_size' => request('memory_size'),
                'cpu_frequency' => request('cpu_frequency'),
                'system_guid' => request('system_guid'),

                'user_id' => auth()->user()->id,
            ]);

        return [true, null, 'adminsavedeviceinfo'];
    }
}
