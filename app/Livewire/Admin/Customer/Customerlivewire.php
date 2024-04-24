<?php

namespace App\Livewire\Admin\Customer;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Customer\Customer;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Customerlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'note' => '',
        'active' => false,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70',
            'form.phone' => 'required|digits:10|unique:customers,phone,' . $this->model_id,
            'form.email' => 'nullable|email|unique:customers,email,' . $this->model_id,
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [

        'form.name.required' => 'The Name is required.',
        'form.name.min' => 'The Name field must be at least 2 characters.',
        'form.name.max' => 'The Name field must not be greater than 70 characters.',
        'form.phone.required' => 'Phone Number is required.',
        'form.phone.digits' => 'Phone Number must be of 10 digits.',
        'form.email.required' => 'Email field is Required.',
        'form.email.email' => 'The Email field must be a valid email address.',
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
            $customer = Customer::find($this->model_id);
            $customer->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $customer, 'customer_createoredit', session()->getId(), 'WEB', 'Customer was Updated');
            $this->toaster('success', 'Customer was Updated Successfully!!');
        } else {
            $customer = Customer::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $customer, 'customer_createoredit', session()->getId(), 'WEB', 'Customer Created');
            $this->toaster('success', 'Customer Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_customer_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_customer_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_customer_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($customerid, $type): void
    {

        $customer = Customer::find($customerid);

        if ($type == 'edit') {
            $this->form = $customer->only('name', 'phone', 'email', 'note', 'active');
            $this->model_id = $customerid;
        } else {
            $this->showdata = $customer;
        }
    }

    #[Computed]
    public function customer()
    {
        return Customer::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): view
    {
        return view('livewire.admin.customer.customerlivewire');
    }
}
