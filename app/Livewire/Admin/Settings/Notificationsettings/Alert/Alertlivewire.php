<?php

namespace App\Livewire\Admin\Settings\Notificationsettings\Alert;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Notification\Alert;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Alertlivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    protected $listeners = ['formreset'];

    public $formdata = [
        'alertmessage' => '',
        'note' => '',
        'active' => false,
    ];

    protected function rules(): array
    {
        return [
            'form.alertmessage' => 'required|string|min:2|max:70' . $this->model_id,
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.alertmessage.required' => 'The alert message name is required',
        'form.alertmessage.min' => 'The alertmessage field must be at least 2 characters.',
        'form.alertmessage.max' => 'The alertmessage field must not be greater than 70 characters.',

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
            $alert = Alert::find($this->model_id);
            $alert->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $alert, 'alert_createoredit', session()->getId(), 'WEB', 'alert Updated');
            $this->toaster('success', 'Alert Updated Successfully!!');
        } else {
            $alert = Alert::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $alert, 'alert_createoredit', session()->getId(), 'WEB', 'alert Created');
            $this->toaster('success', 'Alert Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_alert_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_alert_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_alert_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($alertid, $type): void
    {
        $alert = Alert::find($alertid);

        if ($type == 'edit') {
            $this->form = $alert->only('alertmessage', 'note', 'active');
            $this->model_id = $alertid;
        } else {
            $this->showdata = $alert;
        }
    }

    #[Computed]
    public function alert()
    {

        return Alert::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('alertmessage', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }
    public function render()
    {
        return view('livewire.admin.settings.notificationsettings.alert.alertlivewire');
    }
}
