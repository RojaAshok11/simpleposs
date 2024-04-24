<?php

namespace App\Livewire\Admin\Settings\Locationsettings\City;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Location\City;
use App\Models\Admin\Settings\Location\State;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Citylivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    protected $listeners = ['formreset'];

    public $formdata = [
        'name' => '',
        'note' => '',
        'state_id' => null,
        'active' => false,
    ];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70|unique:cities,name,' . $this->model_id,
            'form.state_id' => 'required|integer',
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
            'form.state_id' => 'required|integer|min:1',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The city name is required',
        'form.name.unique' => 'This city name has already taken',
        'form.name.min' => 'The name field must be at least 2 characters.',
        'form.name.max' => 'The name field must not be greater than 70 characters.',
        'form.state_id.required' => 'The state name cannot be empty.',
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
            $city = City::find($this->model_id);
            $city->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $city, 'city_createoredit', session()->getId(), 'WEB', 'City Updated');
            $this->toaster('success', 'City Updated Successfully!!');
        } else {
            $city = City::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $city, 'city_createoredit', session()->getId(), 'WEB', 'City Created');
            $this->toaster('success', 'City Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_city_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_city_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_city_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($cityid, $type): void
    {
        $city = City::find($cityid);

        if ($type == 'edit') {
            $this->form = $city->only('name', 'note', 'state_id', 'active');
            $this->model_id = $cityid;
        } else {
            $this->showdata = $city;
        }
    }

    #[Computed]
    public function city()
    {

        return City::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%'))
            ->orWhereHas('state', fn(Builder $q) =>
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
            )
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    #[Computed]
    public function state()
    {
        return State::where('active', true)
            ->pluck('name', 'id');
    }

    public function render(): View
    {
        return view('livewire.admin.settings.locationsettings.city.citylivewire');
    }
}
