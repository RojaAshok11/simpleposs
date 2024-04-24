<?php

namespace App\Http\Controllers\Admin\Web\Reports\Logreport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LogininfoController extends Controller
{
    public function logininfo(): View
    {
        return view('admin.reports.logs.logininfo');
    }

}
