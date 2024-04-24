<?php

namespace App\Http\Controllers\Admin\Web\Settings\Systemsetting;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CurrencymasterController extends Controller
{
    public function currencymaster(): View
    {
        return view('admin.settings.systemsettings.currencymaster.currencymaster');
    }
}
