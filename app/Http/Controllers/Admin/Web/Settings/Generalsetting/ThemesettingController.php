<?php

namespace App\Http\Controllers\Admin\Web\Settings\Generalsetting;

use App\Http\Controllers\Admin\Web\Settings\Generalsetting\ThemesettingController;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ThemesettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function themesetting(): View
    {
        return view('admin.settings.generalsettings.theme.themesetting');

    }

}
