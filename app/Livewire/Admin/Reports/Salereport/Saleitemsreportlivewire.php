<?php

namespace App\Livewire\Admin\Reports\Salereport;

use App\Export\Admin\Reports\Salereport\SaleitemreportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Sale\Saleitem;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Saleitemsreportlivewire extends Component
{
    use reportLivewireTrait;

    public function export()
    {
        $saleitemreport = $this->query()->get();
        return Excel::download(new SaleitemreportExport($saleitemreport), 'saleitemreport.xls');

    }

    public function pdf()
    {
        $saleitemreport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.salereport.saleitemreportpdf', compact('saleitemreport'))->output();
        return response()->streamDownload(fn() => print($pdf), "saleitemreport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {

        return Saleitem::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->where(fn($q) =>
                $q->where('product_name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection);

    }

    #[Computed]
    protected function saleitemreport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.salereport.saleitemsreportlivewire');
    }
}
