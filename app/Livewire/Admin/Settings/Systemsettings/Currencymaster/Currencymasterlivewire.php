<?php

namespace App\Livewire\Admin\Settings\Systemsettings\Currencymaster;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Systemsettings\Currencymaster;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Currencymasterlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'country_name' => '',
        'currency_name' => '',
        'currency' => '',
        'is_default' => false,
        'active' => false,
        'note' => '',
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.country_name' => 'required|string|min:2|max:70|unique:currencymasters,country_name,' . $this->model_id,
            'form.currency_name' => 'required|string|min:2|max:70',
            'form.currency' => 'required|string|min:1|max:10',
            'form.note' => 'nullable|min:5|max:255',
            'form.is_default' => 'nullable|boolean',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.country_name.required' => 'The Country name cannot be empty.',
        'form.country_name.min' => 'The Country name field must be at least 2 characters.',
        'form.country_name.max' => 'The Country name field must not be greater than 70 characters.',
        'form.currency_name.required' => 'The Currency name cannot be empty.',
        'form.currency_name.min' => 'The Currency name field must be at least 2 characters.',
        'form.currency_name.max' => 'The Currency name field must not be greater than 70 characters.',
        'form.currency.required' => 'The Currency cannot be empty.',
        'form.currency.min' => 'The Currency field must be at least 1 characters.',
        'form.currency.max' => 'The Currency field must not be greater than 10 characters.',
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
            $currencymaster = Currencymaster::find($this->model_id);
            $currencymaster->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $currencymaster, 'currencymaster_createoredit', session()->getId(), 'WEB', 'Currency was Updated');
            $this->toaster('success', 'Currency was Updated Successfully!!');
        } else {
            $currencymaster = Currencymaster::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $currencymaster, 'currencymaster_createoredit', session()->getId(), 'WEB', 'Currency Created');
            $this->toaster('success', 'Currency Created Successfully!!');
        }
        $currencymaster->is_default ? Currencymaster::whereNot('id', $currencymaster->id)->update(['is_default' => 0]) : null;
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
            $this->exceptionerror(auth()->user(), 'admin_currencymaster_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_currencymaster_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_currencymaster_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($currencymasterid, $type): void
    {

        $currencymaster = Currencymaster::find($currencymasterid);

        if ($type == 'edit') {
            $this->form = $currencymaster->only('country_name', 'currency_name', 'currency', 'is_default', 'note', 'active');
            $this->model_id = $currencymasterid;
        } else {
            $this->showdata = $currencymaster;
        }
    }

    #[Computed]
    public function currencymaster()
    {
        return Currencymaster::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('country_name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('currency_name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.systemsettings.currencymaster.currencymasterlivewire');
    }
}
