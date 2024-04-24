<?php

namespace App\Livewire\Admin\Reports\Logs;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Models\Admin\Settings\Tracking\Logininfo;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Logininfolivewire extends Component
{

    use datatableLivewireTrait;

    #[Computed]
    public function logininfo()
    {
        return Logininfo::query()
            ->where(fn($q) =>
                $q->where('device', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('browser', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('platform', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('logininfoable', fn(Builder $q) =>
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
        return view('livewire.admin.reports.logs.logininfolivewire');
    }
}
