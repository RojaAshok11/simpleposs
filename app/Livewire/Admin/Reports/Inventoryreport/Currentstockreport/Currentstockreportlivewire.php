<?php

namespace App\Livewire\Admin\Reports\Inventoryreport\Currentstockreport;

use App\Export\Admin\Reports\Inventoryreport\CurrentstockreportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Product\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Currentstockreportlivewire extends Component
{
    use reportLivewireTrait;

    public function export()
    {
        $currentstock = $this->query()->get();
        return Excel::download(new CurrentstockreportExport($currentstock), 'currentstock.xls');
    }

    public function pdf()
    {
        $currentstock = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.inventoryreport.currentstockreport.currentstockreportpdf', compact('currentstock'))->output();
        return response()->streamDownload(fn() => print($pdf), "currentstock_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {

        return Product::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->where('active', true)
            ->where(fn($q) =>
                $q->where('name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection);
    }

    #[Computed]
    protected function currentstock()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.inventoryreport.currentstockreport.currentstockreportlivewire');
    }
}
