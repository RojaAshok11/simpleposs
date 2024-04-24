<?php

namespace App\Http\Controllers\Admin\Web\Settings\Generalsetting;

use App\Http\Controllers\Admin\Web\Settings\Generalsetting\SmssettingController;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SmssettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function smssetting(): View
    {
        return view('admin.settings.generalsettings.sms.smssetting');
    }

}
