<?php

namespace App\Http\Controllers\Admin\Web\Reports\Inventoryreport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CurrentstockreportController extends Controller
{
    public function currentstockreport(): View
    {
        return view('admin.reports.inventoryreport.currentstockreport.currentstockreport');
    }

}
