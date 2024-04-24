<?php

namespace App\Http\Controllers\Admin\Web\Product;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function product(): view
    {
        return view('admin.product.product.product');
    }

    public function stockadjustment(): View
    {
        return view('admin.product.stock.stockadjustment');
    }

    public function stockhistory($id): View
    {
        return view('admin.product.stock.stockhistory', compact('id'));
    }

    public function printbarcode($printcount, $uniqid): View
    {
        return view('admin.product.product.printbarcodeprint', compact('printcount', 'uniqid'));
    }

}
