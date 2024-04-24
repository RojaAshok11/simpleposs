<?php

namespace App\Http\Controllers\Admin\Web\Settings\Pos;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PossettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function possetting(): View
    {
        return view('admin.settings.possettings.pos.possetting');

    }
}
