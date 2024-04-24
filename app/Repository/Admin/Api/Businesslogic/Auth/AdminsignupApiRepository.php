<?php

namespace App\Repository\Admin\Api\Businesslogic\Auth;

use App\Models\Admin\Settings\Location\Area;
use App\Models\Miscellaneous\DeviceInfohelper;
use App\Models\Miscellaneous\Trackmessagehelper;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminsignupApiRepository;
use Carbon\Carbon;

class AdminsignupApiRepository implements IAdminsignupApiRepository
{

    public function adminarealist()
    {
        return [true,
            Area::where('active', true)
                ->select('name', 'uuid')
                ->get(),
            'adminarealist'];
    }

    public function adminsignup()
    {

        $admin = User::where('admin_mobile', request('admin_mobile'))->first();

        if (!$admin) {
            $admin = User::create(
                [
                    'name' => request('admin_name'),
                    'admin_address' => request('admin_address'),
                    'admin_mobile' => request('admin_mobile'),
                    'admin_landline' => request('admin_landline'),
                    'area_id' => Area::where('uuid', request('admin_areauuid'))->first()->id,
                    'admin_email' => request('admin_email'),
                    'admin_website' => request('admin_website'),
                    'head_name' => request('head_name'),
                    'head_mobile' => request('head_mobile'),
                    'head_email' => request('head_email'),
                    'alternative_name' => request('alternative_name'),
                    'alternative_mobile' => request('alternative_mobile'),
                    'alternative_email' => request('alternative_email'),
                    'password' => request('password'),
                    'latitude' => request('latitude'),
                    'longitude' => request('longitude'),
                ]
            );

            $tokenResult = $admin->createToken('appToken', ['admin']);
            $token = $tokenResult->token;
            if (request()->remember_me) {
                $token->expires_at = Carbon::now()->addYear(2);
            }
            $token->save();

            $data['token'] = $tokenResult->accessToken;
            $data['token_type'] = 'Bearer';
            $data['is_approved'] = 0;

            Trackmessagehelper::trackmessage($admin, $admin, 'admin_api_adminsignup', substr($data['token'], -33), 'API', 'Admin Login');
            DeviceInfohelper::deviceInfo($admin, substr($data['token'], -33), 'API');

            return [true, $data, 'Signup successfully.'];
        } else {
            return [false, 'Already Mobile Number Exists'];
        }

    }
    public function adminsignupapproval()
    {
        User::where('is_approved', false)->update(['is_approved' => true]);
        return [true, null, 'adminsignupapproval'];
    }
}
