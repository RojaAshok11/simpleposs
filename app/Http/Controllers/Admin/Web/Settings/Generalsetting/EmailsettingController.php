<?php

namespace App\Http\Controllers\Admin\Web\Settings\Generalsetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EmailsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailsetting(): View
    {
        return view('admin.settings.generalsettings.email.emailsetting');
       
    }

}
