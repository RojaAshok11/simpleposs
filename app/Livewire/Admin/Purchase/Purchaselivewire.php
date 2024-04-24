<?php

namespace App\Livewire\Admin\Purchase;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Purchase\Purchase;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Purchaselivewire extends Component
{
    use datatableLivewireTrait;

    public $showdata;

    protected function databind($purchaseid, $type): void
    {
        $this->showdata = Purchase::with('purchaseitem')->find($purchaseid);
    }

    #[Computed]
    public function purchase()
    {
        return Purchase::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('supplier_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.purchase.purchaselivewire');
    }
}
