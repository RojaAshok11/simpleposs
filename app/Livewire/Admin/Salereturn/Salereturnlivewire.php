<?php

namespace App\Livewire\Admin\Salereturn;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Salereturn\Salereturn;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Salereturnlivewire extends Component
{
    use datatableLivewireTrait;
    public $showdata;

    protected function databind($salereturnid, $type): void
    {

        $salereturn = Salereturn::find($salereturnid);

        if ($type == 'show') {
            $this->showdata = $salereturn;
        }
    }

    #[Computed]
    public function salesreturn()
    {
        return Salereturn::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('customer_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('customer_phone', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.salereturn.salereturnlivewire');
    }
}
