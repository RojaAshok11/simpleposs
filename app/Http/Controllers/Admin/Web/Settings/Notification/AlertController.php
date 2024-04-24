<?php

namespace App\Http\Controllers\Admin\Web\Settings\Notification;

use App\Http\Controllers\Controller;

class AlertController extends Controller
{
    public function alert()
    {
        return view('admin.settings.notificationsettings.alert.alert');
    }
}
