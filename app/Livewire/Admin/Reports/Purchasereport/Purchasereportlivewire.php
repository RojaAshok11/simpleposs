<?php

namespace App\Livewire\Admin\Reports\Purchasereport;

use App\Export\Admin\Reports\Purchasereport\PurchasereportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Purchase\Purchase;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Purchasereportlivewire extends Component
{
    use reportLivewireTrait;

    public function export()
    {
        $purchasereport = $this->query()->get();
        return Excel::download(new PurchasereportExport($purchasereport), 'purchasereport.xls');
    }

    public function pdf()
    {
        $purchasereport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.purchasereport.purchasereportpdf', compact('purchasereport'))->output();
        return response()->streamDownload(fn() => print($pdf), "purchasereport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {
        return Purchase::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->where(fn($q) =>
                $q->where('supplier_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('supplier_phone', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('uniqid', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection);
    }

    #[Computed]
    protected function purchasereport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.purchasereport.purchasereportlivewire');
    }
}
