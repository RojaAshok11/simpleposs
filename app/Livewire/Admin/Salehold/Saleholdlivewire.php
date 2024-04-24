<?php

namespace App\Livewire\Admin\Salehold;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Salehold\Salehold;
use App\Models\Admin\Salehold\Saleholditem;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Saleholdlivewire extends Component
{

    use datatableLivewireTrait;

    public $showdata;

    protected function databind($saleholdid, $type): void
    {
        $this->showdata = Salehold::with('saleholditem')->find($saleholdid);
    }

    public function deletemodal($saleholdid): void
    {
        $this->model_id = $saleholdid;
        $this->dispatch('deletemodal');
    }

    public function deletehold()
    {
        $salehold = Salehold::find($this->model_id);
        Saleholditem::where('salehold_id', $this->model_id)->delete();
        $salehold->delete();
        $this->dispatch('alert',
            ['type' => 'success', 'message' => 'Deleted Successfully!!']);
        $this->dispatch('closedeletemodal');
    }

    #[Computed]
    public function salehold()
    {
        return Salehold::query()
            ->where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }
    public function render()
    {
        return view('livewire.admin.salehold.saleholdlivewire');
    }
}
