<?php

namespace App\Http\Controllers\Admin\Web\Sale;

use App\Http\Controllers\Controller;
use App\Models\Admin\Sale\Sale;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function sale(): view
    {
        return view('admin.sale.sale');
    }

    public function salehold(): view
    {
        return view('admin.salehold.salehold');
    }

    public function salecreateoredit($type = null, $id = null): View
    {
        return view('admin.sale.salecreateoredit', compact('id', 'type'));
    }

    public function print($id): View
    {
        return view('admin.sale.print',
            [
                'sale' => Sale::with('saleitem')->find($id),
            ]);
    }

    public function salereturn(): view
    {
        return view('admin.salereturn.salereturn ');
    }

    public function salereturncreate($id = null): View
    {
        return view('admin.salereturn.salereturncreate', compact('id'));
    }
}
