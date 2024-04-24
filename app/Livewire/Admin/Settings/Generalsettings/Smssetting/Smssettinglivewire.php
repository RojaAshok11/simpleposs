<?php

namespace App\Livewire\Admin\Settings\Generalsettings\Smssetting;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Generalsettings\Smssetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Smssettinglivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'provider_name' => '',
        'sid' => '',
        'sender_id' => '',
        'token' => '',
        'url' => '',
        'country_code' => '',
        'phone_no' => '',
        'is_default' => false,
        'active' => false,
        'note' => '',
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.provider_name' => 'required|min:2|max:70',
            'form.sid' => 'required',
            'form.sender_id' => 'required',
            'form.token' => 'required',
            'form.url' => 'required',
            'form.country_code' => 'required',
            'form.phone_no' => 'required|min:10',
            'form.is_default' => 'nullable|boolean',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [
        'form.provider_name.required' => 'The provider name cannot be empty.',
        'form.provider_name.min' => 'The provider name field must be at least 2 characters.',
        'form.provider_name.max' => 'The provider name field must not be greater than 8 characters.',
        'form.sid.required' => 'The sid cannot be empty.',
        'form.sender_id.required' => 'The senderid cannot be empty.',
        'form.token.required' => 'The token cannot be empty.',
        'form.country_code.required' => 'The countrycode cannot be empty.',
        'form.phone_no.min:10' => 'The phone no field must be at least 10 number.',
        'form.note.min' => 'The SMS note field must be at least 5 characters.',
        'form.note.max' => 'The SMS note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {

        if ($this->model_id) {
            $smssetting = Smssetting::find($this->model_id);
            $smssetting->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $smssetting, 'smssetting_createoredit', session()->getId(), 'WEB', 'SMS Setting Updated');
            $this->toaster('success', 'SMS Setting Updated Successfully!!');
        } else {
            $smssetting = Smssetting::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $smssetting, 'smssetting_createoredit', session()->getId(), 'WEB', 'SMS Setting Created');
            $this->toaster('success', 'SMS Setting Created Successfully!!');
        }
        $smssetting->is_default ? Smssetting::whereNot('id', $smssetting->id)->update(['is_default' => 0]) : null;
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
            $this->exceptionerror(auth()->user(), 'admin_smssetting_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_smssetting_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_smssetting_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($smssettingid, $type): void
    {
        $smssetting = Smssetting::find($smssettingid);

        if ($type == 'edit') {
            $this->form = $smssetting->only('provider_name', 'sid', 'sender_id', 'token', 'url', 'country_code', 'phone_no', 'is_default', 'active', 'note');
            $this->model_id = $smssettingid;
        } else {
            $this->showdata = $smssetting;
        }
    }

    #[Computed]
    public function smssetting()
    {

        return Smssetting::query()
            ->active()
            ->where(fn($query) => $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('provider_name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.generalsettings.smssetting.smssettinglivewire');
    }
}
