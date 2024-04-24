<?php

namespace App\Livewire\Admin\Reports\Salereport;

use App\Export\Admin\Reports\Salereport\AmountcdreportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Creditdebit\Amountcd;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Amountcdreportlivewire extends Component
{
    use reportLivewireTrait;

    public function export()
    {
        $amountcdreport = $this->query()->get();
        return Excel::download(new AmountcdreportExport($amountcdreport), 'creditordebitreport.xls');

    }

    public function pdf()
    {
        $amountcdreport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.salereport.amountcdreportpdf', compact('amountcdreport'))->output();
        return response()->streamDownload(fn() => print($pdf), "creditordebitreport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {
        return Amountcd::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"]
        )->orderBy($this->sortColumnName, $this->sortDirection);

    }

    #[Computed]
    protected function amountcdreport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    #[Computed]
    public function balance()
    {
        return Companysetting::first()->balance;
    }

    public function render()
    {
        return view('livewire.admin.reports.salereport.amountcdreportlivewire');
    }
}
