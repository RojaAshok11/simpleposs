<?php

namespace App\Livewire\Admin\Settings\Notificationsettings\Pushnotification;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Notification\Pushnotification;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Pushnotificationlivewire extends Component
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
            'form.name' => 'required|string|min:2|max:70|unique:branches,name,' . $this->model_id,
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The branch name is required',
        'form.name.unique' => 'This branch name has already taken',
        'form.name.min' => 'The branch name field must be at least 2 characters.',
        'form.name.max' => 'The branch name field must not be greater than 70 characters.',

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
            $pushnotification = Pushnotification::find($this->model_id);
            $pushnotification->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $pushnotification, 'pushnotification_createoredit', session()->getId(), 'WEB', 'pushnotification Updated');
            $this->toaster('success', 'Notification Updated Successfully!!');
        } else {
            $pushnotification = Pushnotification::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $pushnotification, 'pushnotification_createoredit', session()->getId(), 'WEB', 'pushnotification Created');
            $this->toaster('success', 'Notification Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_pushnotification_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_pushnotification_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_pushnotification_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($pushnotificationid, $type): void
    {
        $pushnotification = Pushnotification::find($pushnotificationid);

        if ($type == 'edit') {
            $this->form = $pushnotification->only('name', 'note', 'active');
            $this->model_id = $pushnotificationid;
        } else {
            $this->showdata = $pushnotification;
        }
    }

    #[Computed]
    public function pushnotification()
    {

        return Pushnotification::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render()
    {
        return view('livewire.admin.settings.notificationsettings.pushnotification.pushnotificationlivewire');
    }
}
