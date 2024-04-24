<?php

namespace App\Http\Controllers\Admin\Web\Reports\Purchasereport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PurchasereportController extends Controller
{
    public function purchasereport(): View
    {
        return view('admin.reports.purchasereport.purchasereport');
    }

    public function purchaseitemreport(): View
    {
        return view('admin.reports.purchasereport.purchaseitemreport');
    }

}
