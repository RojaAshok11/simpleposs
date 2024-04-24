<?php

namespace App\Livewire\Livewirehelper\Offline;

use Livewire\Component;

class Offlinelivewire extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div  wire:offline>
        <span class="badge text-bg-warning">This Application is currently offline.</span>
        </div>
        HTML;
    }
}
