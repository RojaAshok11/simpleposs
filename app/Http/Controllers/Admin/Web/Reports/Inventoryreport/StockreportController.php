<?php

namespace App\Http\Controllers\Admin\Web\Reports\Inventoryreport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StockreportController extends Controller
{
    public function stockreport(): View
    {
        return view('admin.reports.inventoryreport.stockreport.stockreport');
    }

}
