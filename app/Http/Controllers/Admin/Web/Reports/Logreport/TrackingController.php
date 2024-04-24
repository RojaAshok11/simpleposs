<?php

namespace App\Http\Controllers\Admin\Web\Reports\Logreport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function tracking(): View
    {
        return view('admin.reports.logs.tracking');
    }
}
