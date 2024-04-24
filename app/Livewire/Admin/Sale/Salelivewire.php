<?php

namespace App\Livewire\Admin\Sale;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Sale\Sale;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Salelivewire extends Component
{
    use datatableLivewireTrait;

    public $showdata;

    protected function databind($saleid, $type): void
    {
        $this->showdata = Sale::with('saleitem')->find($saleid);
    }

    public function print($printid): void
    {
        $this->databind($printid, 'print');
        // dd($printid);
        $this->dispatch('printmodal');
    }

    #[Computed]
    public function sale()
    {
        return Sale::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.sale.salelivewire');
    }
}
