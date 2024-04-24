<?php

namespace App\Livewire\Admin\Settings\Generalsettings\Emailsetting;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Generalsettings\Emailsetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Emailsettinglivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'provider_name' => '',
        'email_from_name' => '',
        'email_from_mail' => '',
        'email_mail_driver' => '',
        'email_mail_host' => '',
        'email_mail_port' => '',
        'email_mail_username' => '',
        'email_mail_password' => '',
        'email_mail_encryption' => '',
        'is_default' => false,
        'active' => false,
        'note' => '',
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.provider_name' => 'required|min:2|max:70',
            'form.email_from_name' => 'required|min:2|max:70',
            'form.email_from_mail' => 'required|email|unique:emailsettings,email_from_mail,' . $this->model_id,

            'form.email_mail_driver' => 'required|min:2|max:70',

            'form.email_mail_host' => 'required|min:2|max:70',
            'form.email_mail_port' => 'required|min:2|max:70',

            'form.email_mail_username' => 'required|min:2|max:70',
            'form.email_mail_password' => 'required|min:2|max:70',

            'form.email_mail_encryption' => 'required|min:2|max:70',
            'form.is_default' => 'nullable|boolean',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',

        ];
    }

    protected $messages = [
        'form.provider_name.required' => 'The Provider name cannot be empty.',
        'form.provider_name.min' => 'The Provider name field must be at least 2 characters.',
        'form.provider_name.max' => 'The Provider name field must not be greater than 70 characters.',

        'form.email_from_name.required' => 'The Email name cannot be empty.',
        'form.email_from_name.min' => 'The Email name field must be at least 2 characters.',
        'form.email_from_name.max' => 'The Email name field must not be greater than 70 characters.',

        'form.email_from_mail.required' => 'The Email cannot be empty.',
        'form.email_from_mail.email' => 'The email field must be a valid email address.',
        'form.email_from_mail.unique' => 'The email has already been taken',

        'form.email_mail_driver.required' => 'The Driver Name cannot be empty.',
        'form.email_mail_driver.min' => 'The Driver name field must be at least 2 characters.',
        'form.email_mail_driver.max' => 'The Driver name field must not be greater than 70 characters.',

        'form.email_mail_host.required' => 'The Host Name cannot be empty.',
        'form.email_mail_host.min' => 'The Host name field must be at least 2 characters.',
        'form.email_mail_host.max' => 'The Host name field must not be greater than 70 characters.',

        'form.email_mail_port.required' => 'The Port Name cannot be empty.',
        'form.email_mail_port.min' => 'The Port name field must be at least 2 characters.',
        'form.email_mail_port.max' => 'The Port name field must not be greater than 70 characters.',

        'form.email_mail_username.required' => 'The Username Name cannot be empty.',
        'form.email_mail_username.min' => 'The Username name field must be at least 2 characters.',
        'form.email_mail_username.max' => 'The Username name field must not be greater than 70 characters.',

        'form.email_mail_password.required' => 'The Password cannot be empty.',
        'form.email_mail_password.min' => 'The Password field must be at least 2 characters.',
        'form.email_mail_password.max' => 'The Password field must not be greater than 70 characters.',

        'form.email_mail_encryption.required' => 'The Encryption cannot be empty.',
        'form.email_mail_encryption.min' => 'The Encryption field must be at least 2 characters.',
        'form.email_mail_encryption.max' => 'The Encryption field must not be greater than 70 characters.',

        'form.is_default' => 'nullable|boolean',
        'form.active' => 'nullable|boolean',
        'form.note.min' => 'The Note field must be at least 5 characters.',
        'form.note.max' => 'The Note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {
        if ($this->model_id) {
            $emailsetting = Emailsetting::find($this->model_id);
            $emailsetting->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $emailsetting, 'emailsetting_createoredit', session()->getId(), 'WEB', 'Email Setting Updated');
            $this->toaster('success', 'Email Setting Updated Successfully!!');
        } else {
            $emailsetting = Emailsetting::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $emailsetting, 'emailsetting_createoredit', session()->getId(), 'WEB', 'Email Setting Created');
            $this->toaster('success', 'Email Setting Created Successfully!!');
        }

        $emailsetting->is_default ? Emailsetting::whereNot('id', $emailsetting->id)->update(['is_default' => 0]) : null;
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
            $this->exceptionerror(auth()->user(), 'admin_emailsetting_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_emailsetting_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_emailsetting_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($emailsettingid, $type): void
    {
        $emailsetting = Emailsetting::find($emailsettingid);

        if ($type == 'edit') {
            $this->form = $emailsetting->only('provider_name', 'email_from_name', 'email_from_mail', 'email_mail_driver', 'email_mail_host', 'email_mail_port', 'email_mail_username', 'email_mail_password', 'email_mail_encryption', 'is_default', 'active', 'note', );
            $this->model_id = $emailsettingid;
        } else {
            $this->showdata = $emailsetting;
        }
    }
    #[Computed]
    public function emailsetting()
    {

        return Emailsetting::query()
            ->active()
            ->where(fn($query) => $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('provider_name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.generalsettings.emailsetting.emailsettinglivewire');
    }
}
