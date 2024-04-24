<?php

namespace App\Http\Controllers\Admin\Web\Settings\Mastersetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProductcategoryController extends Controller
{
    public function productcategory(): View
    {
        return view('admin.settings.mastersettings.productcategory.productcategory');
    }
}
