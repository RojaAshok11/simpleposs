<?php

namespace App\Livewire\Admin\Expense;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Expense\Expense;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Models\Admin\Settings\Mastersettings\Expensecategory;
use App\Models\Miscellaneous\Trackmessagehelper;
use Carbon\Carbon;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Expenselivewire extends Component
{

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'name' => '',
        'date' => '',
        'expensecategory_id' => null,
        'amount' => '',
        'note' => '',
        'active' => false,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70',
            'form.date' => 'required|date',
            'form.expensecategory_id' => 'required|integer',
            'form.amount' => 'required|numeric|min:1|max:999999',
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [

        'form.name.required' => 'The Name is required.',
        'form.name.min' => 'The Name field must be at least 2 characters.',
        'form.name.max' => 'The Name field must not be greater than 70 characters.',
        'form.date.required' => 'Date is Required',
        'form.expensecategory_id.required' => 'The EC field must be mandatory.',
        'form.amount.required' => 'The amount field must be mandatory',
        'form.amount.min' => 'The amount field must be at least 1 characters.',
        'form.amount.max' => 'The amount field must not be greater than 999999 characters.',
        'form.note.min' => 'The note field must be at least 5 characters.',
        'form.note.max' => 'The note field must not be greater than 255 characters.',
    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
        $this->form['date'] = Carbon::today()->format('Y-m-d');
    }

    protected function createorupdate($data): void
    {
        if ($this->model_id) {
            $expense = Expense::find($this->model_id);
            $this->amountcreditanddebit($expense, 'UPDATE');
            $expense->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $expense, 'expense_createoredit', session()->getId(), 'WEB', 'Expense was Updated');
            $this->toaster('success', 'Expense was Updated Successfully!!');
        } else {
            $expense = Expense::create($data);
            $this->amountcreditanddebit($expense, 'CREATE');
            Trackmessagehelper::trackmessage(auth()->user(), $expense, 'expense_createoredit', session()->getId(), 'WEB', 'Expense Created');
            $this->toaster('success', 'Expense Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_expense_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_expense_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_expense_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($expenseid, $type): void
    {

        $expense = Expense::find($expenseid);

        if ($type == 'edit') {
            $this->form = $expense->only('name', 'date', 'expensecategory_id', 'amount', 'note', 'active');
            $this->model_id = $expenseid;
        } else {
            $this->showdata = $expense;
        }
    }

    protected function amountcreditanddebit($expense, $type): void
    {

        $companysetting = Companysetting::first();

        if ($type == 'CREATE') {
            $expense->amountcdable()
                ->create([
                    'credit' => 0,
                    'debit' => $this->form['amount'],
                    'balance' => $companysetting->balance - $this->form['amount'],
                    'c_or_d' => 'D',
                ]);

            $companysetting->balance = $companysetting->balance - $this->form['amount'];
            $companysetting->save();

        } else { // UPDATE
            if ($expense->amount >= $this->form['amount']) {
                $expense->amountcdable()
                    ->create([
                        'credit' => ($expense->amount - $this->form['amount']),
                        'debit' => 0,
                        'balance' => $companysetting->balance + ($expense->amount - $this->form['amount']),
                        'c_or_d' => 'C',
                    ]);
                $companysetting->balance = $companysetting->balance + ($expense->amount - $this->form['amount']);
            } else {
                $expense->amountcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => ($this->form['amount'] - $expense->amount),
                        'balance' => $companysetting->balance + ($expense->amount - $this->form['amount']),
                        'c_or_d' => 'D',
                    ]);
                $companysetting->balance = $companysetting->balance + ($expense->amount - $this->form['amount']);
            }
            $companysetting->save();
        }
    }

    #[Computed]
    public function expense()
    {
        return Expense::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    #[Computed]
    public function expensecategory()
    {
        return Expensecategory::where('active', true)
            ->pluck('name', 'id');
    }

    public function render(): View
    {
        return view('livewire.admin.expense.expenselivewire');
    }
}
