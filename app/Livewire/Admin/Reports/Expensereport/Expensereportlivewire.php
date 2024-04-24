<?php

namespace App\Livewire\Admin\Reports\Expensereport;

use App\Export\Admin\Reports\Expensereport\ExpensereportExport;
use App\Livewire\Livewirehelper\Report\reportLivewireTrait;
use App\Models\Admin\Expense\Expense;
use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Expensereportlivewire extends Component
{
    use reportLivewireTrait;
    public $activestatus = "";

    public function export()
    {
        $expensereport = $this->query()->get();
        return Excel::download(new ExpensereportExport($expensereport), 'expensereport.xls');
    }

    public function pdf()
    {
        $expensereport = $this->query()->get();
        $pdf = PDF::loadView('livewire.admin.reports.expensereport.expensereportpdf', compact('expensereport'))->output();
        return response()->streamDownload(fn() => print($pdf), "expensereport_" . date('d-m-y') . ".pdf");
    }

    protected function query()
    {

        return Expense::whereBetween('created_at', [$this->from_date . " 00:00:00", $this->to_date . " 23:59:59"])
            ->when($this->activestatus != '', fn($q) =>
                $q->where("expensecategory_id", $this->activestatus))
            ->where(fn($query) =>
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('expensecategory', fn($q) => $q->where('name', 'like', '%' . $this->searchTerm . '%')),
            )->orderBy($this->sortColumnName, $this->sortDirection);
    }

    #[Computed]
    public function expensecategory()
    {
        return Expensecategory::where('active', true)
            ->pluck('name', 'id');
    }

    #[Computed]
    protected function expensereport()
    {
        return $this->query()
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.reports.expensereport.expensereportlivewire');
    }
}
