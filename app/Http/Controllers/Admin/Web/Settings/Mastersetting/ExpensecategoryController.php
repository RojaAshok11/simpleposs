<?php

namespace App\Http\Controllers\Admin\Web\Settings\Mastersetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ExpensecategoryController extends Controller
{
    public function expensecategory(): View
    {
        return view('admin.settings.mastersettings.expensecategory.expensecategory');
    }
}
