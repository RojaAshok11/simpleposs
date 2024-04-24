<?php

namespace App\Http\Controllers\Admin\Web\Settings\Location;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CityController extends Controller
{
    public function city(): View
    {
        return view('admin.settings.locationsettings.city.city');
    }
}
