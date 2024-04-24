<?php

namespace App\Livewire\Admin\Settings\Systemsettings\Timezonemaster;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Systemsettings\Timezonemaster;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Timezonemasterlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'country_name' => '',
        'time_zone' => '',
        'note' => '',
        'active' => false,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.country_name' => 'required|string|min:2|max:70|unique:timezonemasters,country_name,' . $this->model_id,
            'form.time_zone' => 'required|string|min:2|max:70',
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.country_name.required' => 'The Country name cannot be empty.',
        'form.country_name.min' => 'The Country name field must be at least 2 characters.',
        'form.country_name.max' => 'The Country name field must not be greater than 70 characters.',
        'form.time_zone.required' => 'The Timezone cannot be empty.',
        'form.time_zone.min' => 'The Timezone field must be at least 2 characters.',
        'form.time_zone.max' => 'The Timezone field must not be greater than 70 characters.',
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
            $timezonemaster = Timezonemaster::find($this->model_id);
            $timezonemaster->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $timezonemaster, 'timezonemaster_createoredit', session()->getId(), 'WEB', 'Timezone was Updated');
            $this->toaster('success', 'Timezone was Updated Successfully!!');
        } else {
            $timezonemaster = Timezonemaster::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $timezonemaster, 'timezonemaster_createoredit', session()->getId(), 'WEB', 'Timezone Created');
            $this->toaster('success', 'Timezone Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_timezonemaster_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_timezonemaster_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_timezonemaster_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($timezonemasterid, $type): void
    {

        $timezonemaster = Timezonemaster::find($timezonemasterid);

        if ($type == 'edit') {
            $this->form = $timezonemaster->only('country_name', 'time_zone', 'note', 'active');
            $this->model_id = $timezonemasterid;
        } else {
            $this->showdata = $timezonemaster;
        }
    }

    #[Computed]
    public function timezonemaster()
    {
        return Timezonemaster::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('country_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.systemsettings.timezonemaster.timezonemasterlivewire');
    }
}
