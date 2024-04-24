<?php

namespace App\Http\Controllers\Admin\Web\Settings\Mastersetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UomController extends Controller
{
    public function uom(): View
    {
        return view('admin.settings.mastersettings.uom.uom');
    }
}
