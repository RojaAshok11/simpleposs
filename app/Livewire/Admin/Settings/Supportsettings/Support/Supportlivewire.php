<?php

namespace App\Livewire\Admin\Settings\Supportsettings\Support;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Support\Support;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Supportlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'description' => '',
        'type' => 0,
        'panel' => 0,
        'active' => false,
        'note' => '',
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.description' => 'required|min:5|max:800',
            'form.type' => 'required|not_in:0',
            'form.panel' => 'required|not_in:0',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [
        'form.description.required' => 'The Description cannot be empty.',
        'form.description.min' => 'The Description field must be at least 5 characters.',
        'form.description.max' => 'The Description field must not be greater than 800 characters.',
        'form.active' => 'The active field must be nullable.',
        'form.type.required' => 'The Type cannot be empty.',
        'form.type.not_in' => 'The selected Type is invalid.',
        'form.panel.required' => 'The Panel cannot be empty.',
        'form.panel.not_in' => 'The selected Panel is invalid.',
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
            $support = Support::find($this->model_id);
            $support->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $support, 'support_createoredit', session()->getId(), 'WEB', 'Support was Updated');
            $this->toaster('success', 'Support was Updated Successfully!!');
        } else {
            $support = Support::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $support, 'support_createoredit', session()->getId(), 'WEB', 'Support Created');
            $this->toaster('success', 'Support Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_support_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_support_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_support_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($supportid, $type): void
    {

        $support = Support::find($supportid);

        if ($type == 'edit') {
            $this->form = $support->only('description', 'panel', 'type', 'active', 'note');
            $this->model_id = $supportid;
        } else {
            $this->showdata = $support;
        }
    }

    #[Computed]
    public function support()
    {
        return Support::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.supportsettings.support.supportlivewire');
    }
}
