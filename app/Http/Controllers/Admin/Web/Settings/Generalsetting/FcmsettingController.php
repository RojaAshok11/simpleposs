<?php

namespace App\Http\Controllers\Admin\Web\Settings\Generalsetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FcmsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fcmsetting(): View
    {
        return view('admin.settings.generalsettings.fcm.fcmsetting');
    }
}
