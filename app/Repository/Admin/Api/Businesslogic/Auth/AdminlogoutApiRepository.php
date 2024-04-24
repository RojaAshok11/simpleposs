<?php

namespace App\Repository\Admin\Api\Businesslogic\Auth;

use App\Models\Miscellaneous\Trackmessagehelper;
use App\Models\User\Auth\User;
use App\Repository\Admin\Api\Interfacelayer\Auth\IAdminlogoutApiRepository;

class AdminlogoutApiRepository implements IAdminlogoutApiRepository
{
    public function adminlogout()
    {
        $admin = auth()->user();
        if ($admin) {
            Trackmessagehelper::trackmessage($admin, $admin, 'admin_api_adminlogout', response()->apisessionid(), 'API', 'Admin Logout');
            $admin = $admin->token();
            $admin->revoke();
            return [true, null, 'Logout successfully'];
        } else {
            return [false, 'Unable to Logout'];
        }
    }
}
