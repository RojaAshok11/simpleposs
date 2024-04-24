<?php

namespace App\Livewire\Admin\Settings\Generalsettings\Themesetting;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Generalsettings\Themesetting;
use App\Models\Miscellaneous\Trackmessagehelper;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Themesettinglivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    protected $listeners = ['formreset'];

    public $formdata = [
        'theme_name' => '',
        'path' => '',
        'collapse_active_color' => '',
        'collapse_activesub_color' => '',
        'is_default' => false,
        'active' => false,
        'note' => '',
    ];

    protected function rules(): array
    {
        return [
            'form.theme_name' => 'required|min:2|max:70',
            'form.path' => 'required',
            'form.collapse_active_color' => 'required',
            'form.collapse_activesub_color' => 'required',
            'form.is_default' => 'nullable|boolean',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [
        'form.theme_name.required' => 'The Theme name cannot be empty.',
        'form.theme_name.min' => 'The Theme name field must be at least 2 characters.',
        'form.theme_name.max' => 'The Theme name field must not be greater than 70 characters.',

        'form.path.required' => 'The Theme path must be required',
        'form.collapse_activesub_color.required' => 'The Sub-Color must be required',
        'form.collapse_active_color.required' => 'The Color must be required',

        'form.note.min' => 'The Theme note field must be at least 5 characters.',
        'form.note.max' => 'The Theme note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
    }

    protected function createorupdate($data): void
    {

        if ($this->model_id) {
            $themesetting = Themesetting::find($this->model_id);
            $themesetting->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $themesetting, 'themesetting_createoredit', session()->getId(), 'WEB', 'Theme Setting Updated');
            $this->toaster('success', 'Theme Setting Updated Successfully!!');
        } else {
            $themesetting = Themesetting::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $themesetting, 'themesetting_createoredit', session()->getId(), 'WEB', 'Theme Setting Created');
            $this->toaster('success', 'Theme Setting Created Successfully!!');
        }
        $themesetting->is_default ? Themesetting::whereNot('id', $themesetting->id)->update(['is_default' => 0]) : null;
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
            $this->exceptionerror(auth()->user(), 'admin_themesetting_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_themesetting_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_themesetting_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($themesettingid, $type): void
    {
        $themesetting = Themesetting::find($themesettingid);

        if ($type == 'edit') {
            $this->form = $themesetting->only('theme_name', 'path', 'collapse_active_color', 'collapse_activesub_color', 'is_default', 'active', 'note');
            $this->model_id = $themesettingid;
        } else {
            $this->showdata = $themesetting;
        }
    }

    #[Computed]
    public function themesetting()
    {

        return Themesetting::query()
            ->active()
            ->where(fn($query) =>
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('theme_name', 'like', '%' . $this->searchTerm . '%'))
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.generalsettings.themesetting.themesettinglivewire');
    }
}
