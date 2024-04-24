<?php

namespace App\Livewire\Admin\Reports\Purchasereport;

use App\Export\Admin\Reports\Purchasereport\PurchaseitemreportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Purchase\Purchaseitem;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Purchaseitemreportlivewire extends Component
{
    use reportLivewireTrait;

    public function export()
    {
        $purchaseitemreport = $this->query()->get();
        return Excel::download(new PurchaseitemreportExport($purchaseitemreport), 'purchaseitemsreport.xls');
    }

    public function pdf()
    {
        $purchaseitemreport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.purchasereport.purchaseitemreportpdf', compact('purchaseitemreport'))->output();
        return response()->streamDownload(fn() => print($pdf), "purchaseitemsreport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {

        return Purchaseitem::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->where(fn($q) =>
                $q->where('product_name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection);
    }

    #[Computed]
    protected function purchaseitemreport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.purchasereport.purchaseitemreportlivewire');
    }
}
