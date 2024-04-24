<?php

namespace App\Livewire\Admin\Reports\Inventoryreport\Stockreport;

use App\Export\Admin\Reports\Inventoryreport\StockreportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Creditdebit\Stockcd;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Stockreportlivewire extends Component
{
    use reportLivewireTrait;

    public function export()
    {
        $stockreport = $this->query()->get();
        return Excel::download(new StockreportExport($stockreport), 'stockcreditdebitreport.xls');
    }

    public function pdf()
    {
        $stockreport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.inventoryreport.stockreport.stockreportpdf', compact('stockreport'))->output();
        return response()->streamDownload(fn() => print($pdf), "stockcreditdebitreport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {

        return Stockcd::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->where(fn($query) =>
                $query
                    ->whereHas('product', fn($q) => $q->where('name', 'like', '%' . $this->searchTerm . '%')))
            ->orderBy($this->sortColumnName, $this->sortDirection);
    }

    #[Computed]
    protected function stockreport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.inventoryreport.stockreport.stockreportlivewire');
    }
}
