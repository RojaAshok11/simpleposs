<?php

namespace App\Http\Controllers\Admin\Web\Reports\Reports;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminreportsController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.reports.reports');
    }
}
