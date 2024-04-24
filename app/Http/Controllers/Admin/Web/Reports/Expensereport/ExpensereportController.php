<?php

namespace App\Http\Controllers\Admin\Web\Reports\Expensereport;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ExpensereportController extends Controller
{
    public function expensereport(): View
    {
        return view('admin.reports.expensereport.expensereport');
    }

}
