<?php

namespace App\Livewire\Admin\Reports\Logs;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Settings\Tracking\Tracking;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Trackinglivewire extends Component
{

    use datatableLivewireTrait;

    #[Computed]
    public function tracking()
    {
        return Tracking::query()
            ->where(fn($q) =>
                $q->where('trackmsg', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('trackable', fn(Builder $q) =>
                        $q->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                            ->orWhere('name', 'like', '%' . $this->searchTerm . '%')
                    )
            )
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.reports.logs.trackinglivewire');
    }

}
