<?php

namespace App\Http\Controllers\Admin\Web\Settings\Support;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function faq(): View
    {
        return view('admin.settings.supportsettings.faq.faq');
    }
}
