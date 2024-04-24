<?php

namespace App\Http\Controllers\Admin\Web\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function supplier(): view
    {
        return view('admin.supplier.supplier');

    }

}
