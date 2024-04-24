<?php

namespace App\Livewire\Admin\Product\Product;

use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Settings\Mastersettings\Productcategory;
use App\Models\Admin\Settings\Mastersettings\Uom;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Productlivewire extends Component
{
    use WithFileUploads;

    use datatableLivewireTrait, miscellaneousLivewireTrait;

    public $image, $existingimage, $tax_type;

    public $showbarcodeproduct = null;
    public $printcount = 12;

    public $formdata = [
        'name' => '',
        'productcategory_id' => null,
        'purchaseprice' => 0,
        'sellingprice' => 0,
        'sku' => '',
        'image' => '',
        'uom_id' => null,
        'note' => '',
        'active' => false,
        'cgst' => null,
        'sgst' => null,
        'igst' => null,
        'cess' => null,
        'hsncode' => null,
        'vat' => null,
        'is_nonveg' => false,
    ];

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string|min:2|max:70',
            'form.productcategory_id' => 'required|integer|min:1',
            'form.purchaseprice' => 'required|numeric|min:1|max:999999',
            'form.sellingprice' => 'required|numeric|min:1|max:999999',
            'form.sku' => 'required|string|min:2|max:70',
            'image' => 'nullable|mimes:jpeg,png,jpg|max:10240',
            'form.uom_id' => 'required|integer|min:1',
            'form.note' => 'nullable|min:5|max:255',
            'form.active' => 'nullable|boolean',
            'form.cgst' => 'required_if:tax_type,==,2|nullable|numeric|max:100',
            'form.sgst' => 'required_if:tax_type,==,2|nullable|numeric|max:100',
            'form.igst' => 'required_if:tax_type,==,2|nullable|numeric|max:100',
            'form.cess' => 'required_if:tax_type,==,2|nullable|numeric|max:100',
            'form.hsncode' => 'required_if:tax_type,==,2|nullable|numeric|max:9999',
            'form.vat' => 'required_if:tax_type,==,3|nullable|numeric|max:100',
            'form.is_nonveg' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'form.name.required' => 'The Product name cannot be empty.',
        'form.name.min' => 'The Product name field must be at least 2 characters.',
        'form.name.max' => 'The Product name field must not be greater than 70 characters.',
        'form.productcategory_id.required' => 'The category name must be mandatory.',
        'form.productcategory_id.min' => 'The category name cannot be empty.',
        'form.purchaseprice.required' => 'The purchase price must be mandatory.',
        'form.purchaseprice.min' => 'The purchase price field must be at least 1.',
        'form.purchaseprice.max' => 'The purchaseprice must not be greater than 999999 characters .',
        'form.sellingprice.required' => 'The selling price must be mandatory.',
        'form.sellingprice.min' => 'The selling price field must be at least 1.',
        'form.sellingprice.max' => 'The selling price must not be greater than 999999 characters .',
        'form.sku.required' => 'The sku field must be mandatory.',
        'form.sku.min' => 'The sku field must be at least 2 characters.',
        'form.sku.max' => 'The sku feild must not be greater than 70 characters . ',
        'form.uom_id.required' => 'The uom field must be mandatory.',
        'form.uom_id.min' => 'The uom field cannot be empty.',
        'form.hsncode.numeric' => 'The hsncode field must be a number.',
        'form.note.min' => 'The note field must be at least 5 characters.',
        'form.note.max' => 'The note field must not be greater than 255 characters.',
        'form.hsncode.required_if' => 'The hsncode field is required.',
        'form.cgst.required_if' => 'The cgst field is required.',
        'form.sgst.required_if' => 'The sgst field is required.',
        'form.igst.required_if' => 'The igst field is required.',
        'form.vat.required_if' => 'The igst field is required.',
        'form.cess.required_if' => 'The cess field is required.',

    ];

    public function mount(): void
    {
        $this->form = $this->formdata;
        $this->tax_type = App::make('possetting')->tax_type;
    }

    protected function createorupdate($data): void
    {
        // $data['image'] = $data['image'] ? Storage::disk('public')->put('product', $this->image) : null;
        // if ($this->existingimage != '' && $this->existingimage == $this->formdata['image']) {
        //     Storage::disk('public')->delete($this->existingimage);
        // }

        if ($this->model_id) {
            if ($this->image) {
                $data['image'] = $this->image->store('image', 'public');
                if ($this->existingimage) {
                    Storage::delete('public/' . $this->existingimage);
                }
                $this->image = null;
            } elseif (empty($this->image) && $this->existingimage) {
                $data['image'] = $this->existingimage;
            } else {
                $data['image'] = null;
            }
            $product = Product::find($this->model_id);
            $product->update($data);
            Trackmessagehelper::trackmessage(auth()->user(), $product, 'product_createoredit', session()->getId(), 'WEB', 'Product was Updated');
            $this->toaster('success', 'Product was Updated Successfully!!');
        } else {
            if ($this->image) {
                $data['image'] = $this->image->store('image', 'public');
            }
            $product = Product::create($data);
            Trackmessagehelper::trackmessage(auth()->user(), $product, 'product_createoredit', session()->getId(), 'WEB', 'Product Created');
            $this->toaster('success', 'Product Created Successfully!!');
        }
    }

    public function store(): void
    {
        $validatedData = $this->validate();
        $validatedData['form']['cgst'] = $validatedData['form']['cgst'] == '' ? null : $validatedData['form']['cgst'];
        $validatedData['form']['sgst'] = $validatedData['form']['sgst'] == '' ? null : $validatedData['form']['sgst'];
        $validatedData['form']['igst'] = $validatedData['form']['igst'] == '' ? null : $validatedData['form']['igst'];
        $validatedData['form']['cess'] = $validatedData['form']['cess'] == '' ? null : $validatedData['form']['cess'];
        $validatedData['form']['hsncode'] = $validatedData['form']['hsncode'] == '' ? null : $validatedData['form']['hsncode'];

        try {

            DB::beginTransaction();
            $this->createorupdate($validatedData['form']);
            DB::commit();

            $this->formreset();
            $this->dispatch('closemodal');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_product_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_product_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_product_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function databind($productid, $type): void
    {

        $product = Product::find($productid);

        if ($type == 'edit') {
            $this->form = $product->only('name', 'productcategory_id', 'purchaseprice', 'sellingprice', 'sku', 'image', 'uom_id', 'note', 'active', 'cgst', 'sgst', 'igst', 'cess', 'hsncode', 'is_nonveg');
            $this->existingimage = $this->form['image'];
            $this->model_id = $productid;
        } else {
            $this->showdata = $product;
        }
    }

    public function showbarcode(Product $product): void
    {
        $this->printcount = 12;
        $this->showbarcodeproduct = $product;
        $this->dispatch('printbarcodemodal');
    }

    public function printbarcode()
    {
        $this->dispatch('printbarcode', count: $this->printcount, uniqid: $this->showbarcodeproduct->uniqid);
    }

    public function formreset(): void
    {
        $this->resetValidation();
        $this->form = $this->formdata;
        $this->model_id = null;
        $this->existingimage = null;
    }

    #[Computed]
    public function product()
    {
        return Product::query()
            ->where(function ($query) {
                $query->where('uniqid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($this->paginationlength)
            ->onEachSide(1);
    }

    #[Computed]
    public function productcategory()
    {
        return Productcategory::where('active', true)
            ->pluck('name', 'id');
    }

    #[Computed]
    public function uom()
    {
        return Uom::where('active', true)
            ->pluck('name', 'id');
    }

    public function render(): View
    {
        return view('livewire.admin.product.product.productlivewire');
    }
}
