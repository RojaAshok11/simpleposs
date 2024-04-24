<?php

namespace App\Livewire\Admin\Pos;

use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

trait Possaledatatablelivewire
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';
    public $paginationlength = 15;

    #[Url( as :'search')]
    public $searchTerm = '';

    public $form;

    #[Locked]
    public $model_id;

    public function create(): void
    {
        $this->formreset();
    }

    public function edit($editid): void
    {
        $this->formreset();
        $this->databind($editid, 'edit');
        $this->dispatch('editmodal');
    }

    public function show($showid): void
    {

        $this->databind($showid, 'show');
        $this->dispatch('showmodal');
    }

    public function updatepagination(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortColumnName === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortColumnName = $field;

    }

}
