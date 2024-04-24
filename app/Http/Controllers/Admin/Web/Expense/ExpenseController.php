<?php

namespace App\Http\Controllers\Admin\Web\Expense;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function expense(): view
    {
        return view('admin.expense.expense');

    }

}
