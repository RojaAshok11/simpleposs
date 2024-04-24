<?php

namespace App\Livewire\Admin\Product\Stock;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Creditdebit\Stockcd;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Stockhistorylivewire extends Component
{

    use datatableLivewireTrait;

    public $product_id;

    public function mount($id): void
    {
        $this->product_id = $id;
    }

    #[Computed]
    public function stockhistory()
    {
        return Stockcd::query()
            ->where('product_id', $this->product_id)
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }
    public function render(): View
    {
        return view('livewire.admin.product.stock.stockhistorylivewire');
    }
}
