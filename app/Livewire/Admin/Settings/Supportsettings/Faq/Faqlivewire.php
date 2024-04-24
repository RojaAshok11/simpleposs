<?php

namespace App\Livewire\Admin\Settings\Supportsettings\Faq;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Settings\Support\Faq;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Faqlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'question' => '',
        'answer' => '',
        'panel' => 0,
        'active' => false,
        'note' => '',
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.question' => 'required|min:5|max:800',
            'form.answer' => 'required|min:5|max:800',
            'form.panel' => 'required|not_in:0',
            'form.active' => 'nullable|boolean',
            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [
        'form.question.required' => 'The Question cannot be empty.',
        'form.question.min' => 'The Question field must be at least 5 characters.',
        'form.question.max' => 'The Question field must not be greater than 800 characters.',

        'form.answer.required' => 'The Answer cannot be empty.',
        'form.answer.min' => 'The Answer field must be at least 5 characters.',
        'form.answer.max' => 'The Answer field must not be greater than 800 characters.',

        'form.panel.required' => 'The Panel cannot be empty.',
        'form.panel.not_in' => 'The selected Panel is invalid.',
        'form.active' => 'The active field must be boolean value.',
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
            $faq = Faq::find($this->model_id);
            $faq->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $faq, 'faq_createoredit', session()->getId(), 'WEB', 'Faq was Updated');
            $this->toaster('success', 'Faq was Updated Successfully!!');
        } else {
            $faq = Faq::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $faq, 'faq_createoredit', session()->getId(), 'WEB', 'Faq Created');
            $this->toaster('success', 'Faq Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_faq_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_faq_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_faq_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($faqid, $type): void
    {

        $faq = Faq::find($faqid);

        if ($type == 'edit') {
            $this->form = $faq->only('question', 'panel', 'answer', 'active', 'note');
            $this->model_id = $faqid;
        } else {
            $this->showdata = $faq;
        }
    }

    #[Computed]
    public function faq()
    {
        return Faq::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('question', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.supportsettings.faq.faqlivewire');
    }
}
