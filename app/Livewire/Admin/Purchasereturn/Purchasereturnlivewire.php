<?php

namespace App\Livewire\Admin\Purchasereturn;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Purchasereturn\Purchasereturn;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Purchasereturnlivewire extends Component
{
    use datatableLivewireTrait;
    public $showdata;

    protected function databind($purchasereturnid, $type): void
    {

        $purchasereturn = Purchasereturn::find($purchasereturnid);

        if ($type == 'show') {
            $this->showdata = $purchasereturn;
        }
    }

    #[Computed]
    public function purchasereturn()
    {
        return Purchasereturn::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('supplier_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('supplier_phone', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }
    public function render()
    {
        return view('livewire.admin.purchasereturn.purchasereturnlivewire');
    }
}
