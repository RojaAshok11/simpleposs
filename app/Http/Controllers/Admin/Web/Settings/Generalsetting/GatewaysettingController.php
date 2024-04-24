<?php

namespace App\Http\Controllers\Admin\Web\Settings\Generalsetting;

use App\Http\Controllers\Admin\Web\Settings\Generalsetting\GatewaysettingController;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class GatewaysettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gatewaysetting(): View
    {
        return view('admin.settings.generalsettings.gateway.gatewaysetting');
    }

}
