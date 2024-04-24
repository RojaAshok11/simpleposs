<?php

namespace App\Livewire\Admin\Settings\Locationsettings\State;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Location\State;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Statelivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    protected $listeners = ['formreset'];

    public $formdata = [
        'name' => '',
        'note' => '',
        'active' => false,
    ];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70|unique:states,name,' . $this->model_id,
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The state name is required',
        'form.name.unique' => 'This state name has already taken',
        'form.name.min' => 'The name field must be at least 2 characters.',
        'form.name.max' => 'The name field must not be greater than 70 characters.',
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
            $state = State::find($this->model_id);
            $state->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $state, 'state_createoredit', session()->getId(), 'WEB', 'State Setting Updated');
            $this->toaster('success', 'State Setting Updated Successfully!!');
        } else {
            $state = State::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $state, 'state_createoredit', session()->getId(), 'WEB', 'State Setting Created');
            $this->toaster('success', 'State Setting Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_state_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_state_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_state_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($stateid, $type): void
    {
        $state = State::find($stateid);

        if ($type == 'edit') {
            $this->form = $state->only('name', 'note', 'active');
            $this->model_id = $stateid;
        } else {
            $this->showdata = $state;
        }
    }

    #[Computed]
    public function state()
    {
        return State::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%')

            )
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.locationsettings.state.statelivewire');
    }
}
