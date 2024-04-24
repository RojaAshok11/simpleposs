<?php

namespace App\Livewire\Admin\Settings\Mastersettings\Uom;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Mastersettings\Uom;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Uomlivewire extends Component
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
            'form.name' => 'required|string|min:2|max:70|unique:uoms,name,' . $this->model_id,
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The uom name is required',
        'form.name.unique' => 'This uom name has already taken',
        'form.name.min' => 'The uom name field must be at least 2 characters.',
        'form.name.max' => 'The uom name field must not be greater than 70 characters.',
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
            $uom = Uom::find($this->model_id);
            $uom->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $uom, 'uom_createoredit', session()->getId(), 'WEB', 'UOM was Updated');
            $this->toaster('success', 'UOM was Updated Successfully!!');
        } else {
            $uom = Uom::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $uom, 'uom_createoredit', session()->getId(), 'WEB', 'UOM Created');
            $this->toaster('success', 'UOM Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_uom_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_uom_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_uom_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($uomid, $type): void
    {

        $uom = Uom::find($uomid);

        if ($type == 'edit') {
            $this->form = $uom->only('name', 'note', 'active');
            $this->model_id = $uomid;
        } else {
            $this->showdata = $uom;
        }
    }

    #[Computed]
    public function uom()
    {
        return Uom::query()
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
        return view('livewire.admin.settings.mastersettings.uom.uomlivewire');
    }
}
