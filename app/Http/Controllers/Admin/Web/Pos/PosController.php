<?php

namespace App\Http\Controllers\Admin\Web\Pos;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PosController extends Controller
{

    public function salepos($type = null, $id = null): View
    {
        return view('admin.pos.pos', compact('id', 'type'));
    }
}
