<?php

namespace App\Http\Controllers\Admin\Web\Reports\Salereport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SalereportController extends Controller
{
    public function salesreport(): View
    {
        return view('admin.reports.salereport.salesreport');
    }

    public function saleitemsreport(): View
    {
        return view('admin.reports.salereport.saleitemsreport');
    }

}
