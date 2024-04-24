<?php

namespace App\Http\Controllers\Admin\Web\Settings\Systemsetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TimezonemasterController extends Controller
{
    public function timezonemaster(): View
    {
        return view('admin.settings.systemsettings.timezonemaster.timezonemaster');
    }
}
