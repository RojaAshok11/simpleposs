<?php

namespace App\Http\Controllers\Admin\Web\Customer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function customer(): view
    {
        return view('admin.customer.customer');

    }

}
