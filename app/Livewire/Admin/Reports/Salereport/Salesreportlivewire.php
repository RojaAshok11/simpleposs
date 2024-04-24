<?php

namespace App\Livewire\Admin\Reports\Salereport;

use App\Export\Admin\Reports\Salereport\SalereportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Sale\Sale;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Salesreportlivewire extends Component
{

    use reportLivewireTrait;

    public $transactionstatus = "";

    public function export()
    {
        $salereport = $this->query()->get();
        return Excel::download(new SalereportExport($salereport), 'salereport.xls');
    }

    public function pdf()
    {
        $salereport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.salereport.salereportpdf', compact('salereport'))->output();
        return response()->streamDownload(fn() => print($pdf), "salereport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {
        return Sale::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->when($this->transactionstatus != '', fn($q) =>
                $q->where("mode", $this->transactionstatus))
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'like', '%' . $this->searchTerm . '%')))
            ->orderBy($this->sortColumnName, $this->sortDirection);
    }

    #[Computed]
    protected function salereport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.salereport.salesreportlivewire');
    }
}
