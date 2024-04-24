<?php

namespace App\Livewire\Admin\Supplier;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Supplier\Supplier;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Supplierlivewire extends Component
{
    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $formdata = [
        'name' => '',
        'phone' => '',
        'active' => false,
        'email' => '',
        'gst' => '',
        'pan' => '',
        'cpname' => '',
        'cpphone' => '',
        'cpmail' => '',
        'address' => '',
        'note' => '',
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70',
            'form.phone' => 'required|digits:10|unique:suppliers,phone,' . $this->model_id,
            'form.email' => 'required|email|unique:suppliers,email,' . $this->model_id,
            'form.gst' => 'nullable|string|size:15',
            'form.pan' => 'nullable|string|size:10',
            'form.cpname' => 'nullable|string|min:4|max:70',
            'form.cpphone' => 'nullable|digits:10|unique:suppliers,cpphone,' . $this->model_id,
            'form.cpmail' => 'nullable|email',
            'form.address' => 'required|string|min:5|max:255',
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
        ];
    }

    protected $messages = [

        'form.name.required' => 'Company Name is required.',
        'form.name.min' => 'The Company Name field must be at least 2 characters.',
        'form.name.max' => 'The Company Name field must not be greater than 70 characters.',
        'form.phone.required' => 'Phone Number is required.',
        'form.phone.digits' => 'Phone Number must be of 10 digits.',
        'form.phone.unique' => 'Phone Number has already been taken.',
        'form.email.required' => 'Email field is Required.',
        'form.email.email' => 'The Email field must be a valid email address.',
        'form.email.unique' => 'Email has already been taken.',
        'form.gst.size' => 'GST should be 15 characters',
        'form.pan.size' => 'Pan should be 10 characters',
        'form.cpname.min' => 'The Name must be at least 4 characters.',
        'form.cpname.max' => 'The Name must not be greater than  70 characters.',
        'form.cpphone.digits' => 'Phone Number must be of 10 digits.',
        'form.cpphone.unique' => 'Phone Number has already been taken.',
        'form.cpmail.email' => 'The Email field must be a valid email address.',
        'form.address.required' => 'Address is required',
        'form.address.min' => 'Address field must be at least 5 characters ',
        'form.address.max' => 'Address field not be greater than 255 characters ',
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
            $supplier = Supplier::find($this->model_id);
            $supplier->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $supplier, 'supplier_createoredit', session()->getId(), 'WEB', 'Supplier was Updated');
            $this->toaster('success', 'Supplier was Updated Successfully!!');
        } else {
            $supplier = Supplier::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $supplier, 'supplier_createoredit', session()->getId(), 'WEB', 'Supplier Created');
            $this->toaster('success', 'Supplier Created Successfully!!');
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
            $this->exceptionerror(auth()->user(), 'admin_supplier_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_supplier_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_supplier_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($supplierid, $type): void
    {

        $supplier = Supplier::find($supplierid);

        if ($type == 'edit') {
            $this->form = $supplier->only('name', 'phone', 'email', 'gst', 'pan', 'cpname', 'cpphone', 'cpmail', 'address', 'note', 'active');
            $this->model_id = $supplierid;
        } else {
            $this->showdata = $supplier;
        }
    }

    #[Computed]
    public function supplier()
    {
        return Supplier::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('phone', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('cpname', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('cpphone', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    public function render(): View
    {
        return view('livewire.admin.supplier.supplierlivewire');
    }
}
