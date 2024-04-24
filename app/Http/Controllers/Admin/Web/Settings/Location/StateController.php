<?php

namespace App\Http\Controllers\Admin\Web\Settings\Location;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StateController extends Controller
{

    public function state(): View
    {
        return view('admin.settings.locationsettings.state.state');
    }
}
