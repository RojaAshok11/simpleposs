<?php

namespace App\Livewire\Livewirehelper\Report;

use Carbon\Carbon;
use Livewire\WithPagination;

trait reportLivewireTrait
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $from_date, $to_date;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $paginationlength = 10;
    public $searchTerm = null;

    public function mount()
    {
        $this->from_date = Carbon::now()->subDays(7)->format('Y-m-d');
        $this->to_date = Carbon::tomorrow()->format('Y-m-d');
    }

    public function updatepagination()
    {
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function clear()
    {
        $this->from_date = Carbon::now()->subDays(7)->format('Y-m-d');
        $this->to_date = Carbon::tomorrow()->format('Y-m-d');
        $this->searchTerm = null;
        $this->resetPage();
    }
}
