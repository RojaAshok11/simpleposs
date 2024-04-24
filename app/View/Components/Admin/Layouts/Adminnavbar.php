<?php

namespace App\View\Components\Admin\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Adminnavbar extends Component
{

    public $modulename;
    /**
     * Create a new component instance.
     */
    public function __construct($modulename)
    {
        $this->modulename = $modulename;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.admin.layouts.adminnavbar');
    }
}
