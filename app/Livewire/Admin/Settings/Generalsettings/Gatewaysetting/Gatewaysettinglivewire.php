<?php

namespace App\Livewire\Admin\Settings\Generalsettings\Gatewaysetting;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Generalsettings\Gatewaysetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Gatewaysettinglivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    protected $listeners = ['formreset'];

    public $formdata = [
        'gateway_name' => '',
        'gateway_username' => '',
        'gateway_secret_key' => '',
        'gateway_publisher_key' => '',
        'is_default' => false,
        'active' => false,
        'note' => '',
    ];

    protected function rules(): array
    {
        return [
            'form.gateway_name' => 'required|min:2|max:70',
            'form.gateway_username' => 'required|min:2|max:70',
            'form.gateway_secret_key' => 'required',
            'form.gateway_publisher_key' => 'required',
            'form.is_default' => 'nullable|boolean',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [
        'form.gateway_name.required' => 'The Gateway name cannot be empty.',
        'form.gateway_username.required' => 'The Gateway user name cannot be empty.',
        'form.gateway_name.min' => 'The Gateway name field must be at least 2 characters.',
        'form.gateway_secret_key.required' => 'The Secret Key field must be requried.',
        'form.gateway_publisher_key.required' => 'The Publisher Key field must be requried.',
        'form.note.min' => 'The Gateway note field must be at least 5 characters.',
        'form.note.max' => 'The Gateway note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {

        if ($this->model_id) {
            $gatewaysetting = Gatewaysetting::find($this->model_id);
            $gatewaysetting->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $gatewaysetting, 'gatewaysetting_createoredit', session()->getId(), 'WEB', 'Gateway Setting Updated');
            $this->toaster('success', 'Gateway Setting Updated Successfully!!');
        } else {
            $gatewaysetting = Gatewaysetting::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $gatewaysetting, 'gatewaysetting_createoredit', session()->getId(), 'WEB', 'Gateway Setting Created');
            $this->toaster('success', 'Gateway Setting Created Successfully!!');
        }
        $gatewaysetting->is_default ? Gatewaysetting::whereNot('id', $gatewaysetting->id)->update(['is_default' => 0]) : null;
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
            $this->exceptionerror(auth()->user(), 'admin_gatewaysetting_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_gatewaysetting_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_gatewaysetting_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($gatewaysettingid, $type): void
    {
        $gatewaysetting = Gatewaysetting::find($gatewaysettingid);

        if ($type == 'edit') {
            $this->form = $gatewaysetting->only('gateway_name', 'gateway_username', 'gateway_secret_key', 'gateway_publisher_key', 'is_default', 'active', 'note');
            $this->model_id = $gatewaysettingid;
        } else {
            $this->showdata = $gatewaysetting;
        }
    }

    #[Computed]
    public function gatewaysetting()
    {

        return Gatewaysetting::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('gateway_name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.generalsettings.gatewaysetting.gatewaysettinglivewire');
    }
}
