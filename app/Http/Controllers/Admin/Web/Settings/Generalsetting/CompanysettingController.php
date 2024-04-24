<?php

namespace App\Http\Controllers\Admin\Web\Settings\Generalsetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CompanysettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function companysetting(): View
    {
        return view('admin.settings.generalsettings.company.companysetting');

    }
}
