<?php

namespace App\Http\Controllers\Admin\Web\Reports\Salereport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AmountcdreportController extends Controller
{
    public function amountcdreport(): View
    {
        return view('admin.reports.salereport.amountcdreport');
    }

}
