<?php

namespace App\Livewire\Admin\Settings\Generalsettings\Fcmsetting;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Generalsettings\Fcmsetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Fcmsettinglivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    protected $listeners = ['formreset'];

    public $formdata = [
        'email' => '',
        'serverkey' => '',
        'is_default' => false,
        'active' => false,
        'note' => '',
    ];

    protected function rules(): array
    {
        return [
            'form.email' => 'required|email',
            'form.serverkey' => 'required|min:2|max:200',
            'form.is_default' => 'nullable|boolean',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [
        'form.theme_name.required' => 'The FCM name cannot be empty.',
        'form.theme_name.min' => 'The FCM name field must be at least 2 characters.',
        'form.theme_name.max' => 'The FCM name field must not be greater than 70 characters.',

        'form.path.required' => 'The FCM path must be required',
        'form.collapse_activesub_color.required' => 'The Sub-Color must be required',
        'form.collapse_active_color.required' => 'The Color must be required',

        'form.note.min' => 'The FCM note field must be at least 5 characters.',
        'form.note.max' => 'The FCM note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {

        if ($this->model_id) {
            $fcmsetting = Fcmsetting::find($this->model_id);
            $fcmsetting->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $fcmsetting, 'fcmsetting_createoredit', session()->getId(), 'WEB', 'FCM Setting Updated');
            $this->toaster('success', 'FCM Setting Updated Successfully!!');
        } else {
            $fcmsetting = Fcmsetting::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $fcmsetting, 'fcmsetting_createoredit', session()->getId(), 'WEB', 'FCM Setting Created');
            $this->toaster('success', 'FCM Setting Created Successfully!!');
        }
        $fcmsetting->is_default ? Fcmsetting::whereNot('id', $fcmsetting->id)->update(['is_default' => 0]) : null;
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
            $this->exceptionerror(auth()->user(), 'admin_fcmsetting_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_fcmsetting_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_fcmsetting_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($fcmsettingid, $type): void
    {
        $fcmsetting = Fcmsetting::find($fcmsettingid);

        if ($type == 'edit') {
            $this->form = $fcmsetting->only('email', 'serverkey', 'is_default', 'active', 'note');
            $this->model_id = $fcmsettingid;
        } else {
            $this->showdata = $fcmsetting;
        }
    }

    #[Computed]
    public function fcmsetting()
    {

        return Fcmsetting::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.generalsettings.fcmsetting.fcmsettinglivewire');
    }
}
