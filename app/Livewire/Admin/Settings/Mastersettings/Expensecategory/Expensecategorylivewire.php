<?php

namespace App\Livewire\Admin\Settings\Mastersettings\Expensecategory;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Expensecategorylivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'name' => '',
        'note' => '',
        'active' => false,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70|unique:expensecategories,name,' . $this->model_id,
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The Expense category name is required',
        'form.name.unique' => 'This Expense category name has already taken',
        'form.name.min' => 'The Expense category name field must be at least 2 characters.',
        'form.name.max' => 'The Expense category name field must not be greater than 70 characters.',
        'form.note.min' => 'The note field must be at least 5 characters.',
        'form.note.max' => 'The note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {
        if ($this->model_id) {
            $expensecategory = Expensecategory::find($this->model_id);
            $expensecategory->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $expensecategory, 'expensecategory_createoredit', session()->getId(), 'WEB', 'Expense Category was Updated');
            $this->toaster('success', 'Expense Category was Updated Successfully!!');
        } else {
            $expensecategory = Expensecategory::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $expensecategory, 'expensecategory_createoredit', session()->getId(), 'WEB', 'Expense Category Created');
            $this->toaster('success', 'Expense Category Created Successfully!!');
        }
    }

    public function store(): void
    {
        $validatedData = $this->validate();
        try {

            DB::beginTransaction();
            $this->createorupdate($this->form);
            DB::commit();

            $this->formreset();
            $this->dispatch('closemodal');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_expensecategory_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_expensecategory_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_expensecategory_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($expensecategoryid, $type): void
    {

        $expensecategory = Expensecategory::find($expensecategoryid);

        if ($type == 'edit') {
            $this->form = $expensecategory->only('name', 'note', 'active');
            $this->model_id = $expensecategoryid;
        } else {
            $this->showdata = $expensecategory;
        }
    }

    #[Computed]
    public function expensecategory()
    {
        return Expensecategory::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.mastersettings.expensecategory.expensecategorylivewire');
    }
}
