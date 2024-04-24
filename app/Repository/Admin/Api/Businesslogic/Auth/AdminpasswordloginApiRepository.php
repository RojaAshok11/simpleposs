<?php

namespace App\Repository\Admin\Api\Businesslogic\Auth;

use App\Models\Miscellaneous\DeviceInfohelper;
use App\Models\Miscellaneous\Trackmessagehelper;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminpasswordloginApiRepository;

class AdminpasswordloginApiRepository implements IAdminpasswordloginApiRepository
{
    public function adminpasswordlogin()
    {
        if (auth()->attempt(['phone' => request('phone'), 'password' => request('password')])) {
            $admin = auth()->user();
            if ($admin->is_accountactive == 1) {
                $data['token'] = $admin->is_accountactive ? $admin->createToken('appToken', ['admin'])->accessToken : null;
                $data['is_accountactive'] = $admin->is_accountactive;
            } else {
                $data['token'] = '';
                $data['is_accountactive'] = $admin->is_accountactive;
            }
            Trackmessagehelper::trackmessage($admin, $admin, 'admin_api_adminpasswordlogin', substr($data['token'], -33), 'API', 'Admin Login');
            DeviceInfohelper::deviceInfo($admin, substr($data['token'], -33), 'API');
            return [true, $data, 'Admin Login Successfully'];
        } else {
            return [false, 'Login Failed'];
        }

    }

}
