<?php

namespace App\Http\Controllers\Admin\Web\Settings\Notification;

use App\Http\Controllers\Controller;

class PushnotificationController extends Controller
{
    //
    public function pushnotification()
    {
        return view('admin.settings.notificationsettings.pushnotification.pushnotification');
    }
}
