<?php

namespace App\Http\Controllers\Admin\Web\Settings\Settings;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminsettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): View
    {
        return view('admin.settings.settings.settings');
    }

}
