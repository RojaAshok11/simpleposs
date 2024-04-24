<?php

namespace App\Http\Controllers\Admin\Web\Settings\Support;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function support(): View
    {
        return view('admin.settings.supportsettings.support.support');
    }
}
