<?php

namespace App\Repository\Admin\Api\Businesslogic\Profile;

use App\Models\Admin\Auth\User;
use App\Models\Miscellaneous\Trackmessagehelper;
use App\Repository\Admin\Api\Interfacelayer\Profile\IAdminprofileApiRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdminprofileApiRepository implements IAdminprofileApiRepository
{
    public function admingetprofile()
    {
        return [true,
            auth()->user()
                ->only('uuid', 'name', 'address', 'phone', 'email', 'created_at', 'updated_at'),
            'Get Profile'];

    }

    public function adminupdateprofile()
    {
        $admin = auth()->user();

        $admin->update(
            [
                'name' => request('name'),
                'address' => request('address'),
                'mobile' => request('mobile'),
                'email' => request('email'),
                'website' => request('website'),
            ]
        );

        Trackmessagehelper::trackmessage($admin, $admin, 'admin_api_updateprofile', substr(request()->header('authorization'), -33), 'API', 'Admin Profile Update');
        return [true, null, 'Updated Admin Profile'];

    }

    public function adminchangepassword()
    {
        $admin = auth()->guard()->user();
        if (Hash::check(request('current_password'), $admin->password)) {
            $admin->update(['password' => request('password')]);
            Trackmessagehelper::trackmessage($admin, $admin, 'admin_api_changepassword', substr(request()->header('authorization'), -33), 'API', 'Admin Change Password');
            return [true, null, 'Password Changed Successfully'];
        } else {
            return [false, 'Please Enter Valid Credentials'];
        }
    }

    public function adminchangeavatar()
    {
        $admin = auth()->user();
        ($admin->avatar) ? Storage::delete('public/' . $admin->avatar) : '';

        $saveimage = Image::make(request('avatar'))
            ->resize(150, 150)
            ->encode('jpg', 90)
            ->stream();

        $admin->avatar = $path = 'admin/image/userprofile/' . time() . '.jpg';
        Storage::disk('public')->put($path, $saveimage, 'public');
        $admin->save();
        Trackmessagehelper::trackmessage($admin, $admin, 'admin_api_changeavatar', substr(request()->header('authorization'), -33), 'API', 'Admin Change Avatar');

        return [true, $admin->avatar, 'changeavatar'];
    }
}
