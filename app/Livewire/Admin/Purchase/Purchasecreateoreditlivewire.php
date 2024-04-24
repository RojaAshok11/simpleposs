<?php

namespace App\Livewire\Admin\Purchase;

use App\Livewire\Admin\Purchase\Purchasecreateoreditlivewire;
use App\Livewire\Admin\Purchase\Purchasecreditordebitlivewire;
use App\Livewire\Admin\Purchase\Purchasesupplierlivewire;
use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Models\Miscellaneous\Trackmessagehelper;
use Carbon\Carbon;
use DB;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Component;

class Purchasecreateoreditlivewire extends Component
{
    use miscellaneousLivewireTrait, datatableLivewireTrait,
    Purchasesupplierlivewire, Purchasecreditordebitlivewire;

    public $formdata = [
        'supplier_id' => '',
        'supplier_name' => '',
        'supplier_phone' => '',
        'supplier_email' => '',
        'supplier_address' => '',
        'gst' => '',
        'pan' => '',

        'purchase_date' => '',

        'sub_total' => 0,
        'discount' => 0,
        'total_items' => 0,
        'total' => 0,
        'freight_charges' => 0,
        'adjustment' => 0,
        'note' => '',
        'roundoff' => 0,
        'taxamt' => null,
        'taxableamt' => null,
        'cgst' => null,
        'sgst' => null,
        'igst' => null,
        'cess' => null,
        'vat' => null,
        'grandtotal' => 0,
    ];

    // Purchase
    public $purchase;

    // Product
    public $product_selected;
    public $product = [];
    public $searchproductlist = [];

    // Key Board Navigation

    public $highlightIndex;

    public $tax_type;

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [

            'product' => 'required',
            'product.*.product_id' => 'required|integer',
            'product.*.product_name' => 'required|string',
            'product.*.product_rate' => 'required|min:1',
            'product.*.product_quantity' => 'required|integer|min:1',
            'product.*.product_subtotal' => 'required',
            'product.*.product_purchaseprice' => 'required',
            'product.*.taxamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.taxable' => 'nullable|required_if:tax_type,==,2',
            'product.*.cgst' => 'nullable|required_if:tax_type,==,2',
            'product.*.cgstamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.sgst' => 'nullable|required_if:tax_type,==,2',
            'product.*.sgstamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.igst' => 'nullable|required_if:tax_type,==,2',
            'product.*.igstamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.cess' => 'nullable|required_if:tax_type,==,2',
            'product.*.cessamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.vatamt' => 'nullable|required_if:tax_type,==,3',
            'product.*.vatamt' => 'nullable|required_if:tax_type,==,3',

            'form.supplier_id' => 'required|integer',

            'form.supplier_name' => 'required|string|min:2|max:70',
            'form.supplier_phone' => 'required|digits:10',
            'form.supplier_email' => 'required|email',
            'form.supplier_address' => 'required|string|min:5|max:255',
            'form.gst' => 'nullable|string|size:15',
            'form.pan' => 'nullable|string|size:10',

            'form.purchase_date' => 'required|date',
            'form.sub_total' => 'required',
            'form.freight_charges' => 'nullable',
            'form.adjustment' => 'nullable',
            'form.discount' => 'nullable',
            'form.total_items' => 'nullable',
            'form.total' => 'required|numeric',
            'form.roundoff' => 'required',
            'form.taxamt' => 'nullable|required_if:tax_type,==,2',
            'form.taxableamt' => 'nullable|required_if:tax_type,==,2',
            'form.cgst' => 'nullable|required_if:tax_type,==,2',
            'form.sgst' => 'nullable|required_if:tax_type,==,2',
            'form.igst' => 'nullable|required_if:tax_type,==,2',
            'form.cess' => 'nullable|required_if:tax_type,==,2',
            'form.vat' => 'nullable|required_if:tax_type,==,3',
            'form.grandtotal' => 'required',

            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [

        'form.supplier_id' => 'Supplier Fields are Mandatory',
        'form.supplier_name.required' => 'Supplier Name is required.',
        'form.supplier_name.min' => 'Supplier Name field must be at least 2 characters.',
        'form.supplier_name.max' => 'Supplier Name field must not be greater than 70 characters.',
        'form.supplier_phone.required' => 'Phone Number is required.',
        'form.supplier_phone.digits' => 'Phone Number must be of 10 digits.',
        'form.supplier_email.required' => 'Email field is Required.',
        'form.supplier_email.email' => 'The Email field must be a valid email address.',
        'form.gst.size' => 'GST should be 15 characters',
        'form.pan.size' => 'Pan should be 10 characters',
        'form.supplier_address.required' => 'Address is required',
        'form.supplier_address.min' => 'Address field must be at least 5 characters ',

        'form.purchase_date.required' => 'Purchase Date is Required',

        'product.*.product_id.required' => 'Product ID is Required',
        'product.*.product_name.required' => 'Name is Required',
        'product.*.product_rate.required' => 'Rate is Required',
        'product.*.product_quantity.required' => 'Quantity is Required',
        'product.*.product_quantity.min' => 'Quantity is Invalid',
        'product.*.product_subtotal.required' => 'Subtotal is Required',
        'product.*.product_purchaseprice.required' => 'Actual Price is Required',
        'product' => 'Please Add a Product',

        'form.note.min' => 'The note field must be at least 5 characters.',
        'form.note.max' => 'The note field must not be greater than 255 characters.',
    ];

    public function mount($id): void
    {
        $this->tax_type = App::make('possetting')->tax_type;
        if ($id) {
            $this->purchase = Purchase::with('purchaseitem')->find($id);
            // dd($this->purchase);

            $this->suppliername = $this->purchase->supplier_name;

            foreach ($this->purchase->purchaseitem as $key => $eachpurchaseitem) {
                array_push($this->product,
                    [
                        'product_purchaseitemid' => $eachpurchaseitem->id,
                        'product_id' => $eachpurchaseitem->product_id,
                        'product_name' => $eachpurchaseitem->product_name,
                        'product_quantity' => $eachpurchaseitem->quantity,
                        'product_rate' => $eachpurchaseitem->price,
                        'product_subtotal' => $eachpurchaseitem->total,
                        'product_purchaseprice' => $eachpurchaseitem->purchaseprice,
                        'taxamt' => $eachpurchaseitem->taxamt,
                        'taxable' => $eachpurchaseitem->taxable,
                        'cgst' => $eachpurchaseitem->cgst,
                        'cgstamt' => $eachpurchaseitem->cgstamt,
                        'sgst' => $eachpurchaseitem->sgst,
                        'sgstamt' => $eachpurchaseitem->sgstamt,
                        'cess' => $eachpurchaseitem->cess,
                        'cessamt' => $eachpurchaseitem->cessamt,
                        'vat' => $eachpurchaseitem->vat,
                        'vatamt' => $eachpurchaseitem->vatamt,
                    ]);
            }
            $this->form = $this->purchase->only('supplier_id', 'supplier_name', 'supplier_phone', 'supplier_email', 'supplier_address', 'gst', 'pan', 'purchase_date', 'sub_total', 'discount', 'total_items', 'total', 'freight_charges', 'adjustment', 'note', 'roundoff', 'grandtotal', 'taxamt', 'taxableamt', 'cgst', 'sgst', 'igst', 'cess', 'vat');
        } else {
            $this->form = $this->formdata;
            $this->form['purchase_date'] = Carbon::today()->format('Y-m-d');
        }
    }

    protected function updatepurchase($data): void
    {

        $purchasedata = $this->purchase;
        $this->amountcreditanddebit($purchasedata, 'UPDATE');
        $this->purchase->update($data['form']);

        foreach ($data['product'] as $key => $updateproduct) {
            $this->stockcreditanddebit($purchasedata, $updateproduct);
            $this->purchase
                ->purchaseitem()
                ->updateOrCreate(
                    ['purchase_id' => $this->purchase->id, 'product_id' => $updateproduct['product_id']],
                    [
                        'product_name' => $updateproduct['product_name'],
                        'quantity' => $updateproduct['product_quantity'],
                        'returnable_quantity' => $updateproduct['product_quantity'],
                        'price' => $updateproduct['product_rate'],
                        'total' => $updateproduct['product_subtotal'],
                        'purchaseprice' => $updateproduct['product_purchaseprice'],
                        'taxamt' => $updateproduct['taxamt'],
                        'taxable' => $updateproduct['taxable'],
                        'cgst' => $updateproduct['cgst'],
                        'cgstamt' => $updateproduct['cgstamt'],
                        'sgst' => $updateproduct['sgst'],
                        'sgstamt' => $updateproduct['sgstamt'],
                        'igst' => $updateproduct['igst'],
                        'igstamt' => $updateproduct['igstamt'],
                        'cess' => $updateproduct['cess'],
                        'cessamt' => $updateproduct['cessamt'],
                        'vat' => $updateproduct['vat'],
                        'vatamt' => $updateproduct['vatamt'],
                    ]
                );

        }
        Trackmessagehelper::trackmessage(auth()->user(), $this->purchase, 'purchasecreateoredit', session()->getId(), 'WEB', 'Purchase was Updated');
        $this->toaster('success', 'Purchase was Updated Successfully!!');
    }

    protected function createpurchase($data): void
    {
        $data['form']['source_type'] = 1;
        $purchase = Purchase::create($data['form']);
        $this->amountcreditanddebit($purchase, 'CREATE');
        foreach ($data['product'] as $key => $storeproduct) {
            $this->stockcreditanddebit($purchase, $storeproduct);
            $purchase->purchaseitem()
                ->create([
                    'product_id' => $storeproduct['product_id'],
                    'product_name' => $storeproduct['product_name'],
                    'purchaseprice' => $storeproduct['product_purchaseprice'],
                    'price' => $storeproduct['product_rate'],
                    'quantity' => $storeproduct['product_quantity'],
                    'returnable_quantity' => $storeproduct['product_quantity'],
                    'total' => $storeproduct['product_rate'] * $storeproduct['product_quantity'],
                    'taxamt' => $storeproduct['taxamt'],
                    'taxable' => $storeproduct['taxable'],
                    'cgst' => $storeproduct['cgst'],
                    'cgstamt' => $storeproduct['cgstamt'],
                    'sgst' => $storeproduct['sgst'],
                    'sgstamt' => $storeproduct['sgstamt'],
                    'igst' => $storeproduct['igst'],
                    'igstamt' => $storeproduct['igstamt'],
                    'cess' => $storeproduct['cess'],
                    'cessamt' => $storeproduct['cessamt'],
                    'vat' => $storeproduct['vat'],
                    'vatamt' => $storeproduct['vatamt'],
                ]);
        }

        Trackmessagehelper::trackmessage(auth()->user(), $purchase, 'purchasecreateoredit', session()->getId(), 'WEB', 'Purchase Created');
        $this->toaster('success', 'Purchase Created Successfully!!');
    }

    public function storepurchase(): Redirector
    {
        $validatedData = $this->validate();
        // dd($validatedData);
        try {

            DB::beginTransaction();

            $this->purchase ? $this->updatepurchase($validatedData) : $this->createpurchase($validatedData);

            DB::commit();
            $this->formreset();
            return redirect()->route('adminpurchase');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_purchase_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_purchase_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_purchase_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    public function searchproductreset()
    {
        $this->product_selected = '';
        $this->searchproductlist = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->searchproductlist) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {

        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->searchproductlist) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function searchproduct()
    {
        $this->searchproductlist = Product::where('active', true)
            ->where(fn($q) =>
                $q->where('name', 'like', '%' . $this->product_selected . '%')
                    ->orWhere('sku', 'like', '%' . $this->product_selected . '%'))
            ->whereNotIn('id', collect($this->product)->pluck('product_id'))
            ->take(6)
            ->get();
    }

    public function enterproduct()
    {
        $product = $this->searchproductlist[$this->highlightIndex] ?? null;
        if ($product) {
            $higlightproduct = $this->searchproductlist[$this->highlightIndex];
            $this->onclickproduct($higlightproduct);
        }
    }

    public function onclickproduct(Product $product)
    {
        array_push($this->product,
            [
                'product_purchaseitemid' => null,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_quantity' => 1,
                'product_rate' => $product->purchaseprice,
                'product_subtotal' => $product->purchaseprice,
                'product_purchaseprice' => $product->purchaseprice,
                'vat' => $product->vat,
                'vatamt' => $this->tax_type == 3 && $product->vat ? ($product->vat / 100) * $product->purchaseprice : null,
                'cgst' => $product->cgst,
                'cgstamt' => $this->tax_type == 2 && $product->cgst ? ($product->cgst / 100) * $product->purchaseprice : null,
                'sgst' => $product->sgst,
                'sgstamt' => $this->tax_type == 2 && $product->sgst ? ($product->sgst / 100) * $product->purchaseprice : null,
                'igst' => $product->igst,
                'igstamt' => $this->tax_type == 2 && $product->igst ? ($product->igst / 100) * $product->purchaseprice : null,
                'cess' => $product->cess,
                'cessamt' => $this->tax_type == 2 && $product->cess ? ($product->cess / 100) * $product->purchaseprice : null,
                'taxable' => $product->purchaseprice,
                'taxamt' => $this->tax_type == 3 ? (($product->vat / 100) * $product->purchaseprice) : ($this->tax_type == 2 ? ((($product->cgst / 100) * $product->purchaseprice) + (($product->sgst / 100) * $product->purchaseprice) + (($product->igst / 100) * $product->purchaseprice) + (($product->cess / 100) * $product->purchaseprice)) : null),
            ]);

        $this->overallcalc();

        $this->product_selected = '';
        $this->searchproductlist = [];

    }

    public function productcalculation($key)
    {

        $this->product[$key]['product_subtotal'] = ($this->product[$key]['product_quantity'] ? $this->product[$key]['product_quantity'] : 0)
             * ($this->product[$key]['product_rate'] ? $this->product[$key]['product_rate'] : 0);
        if ($this->tax_type == 3) {
            $this->product[$key]['vatamt'] = $this->product[$key]['product_quantity'] ? ($this->product[$key]['vat'] / 100) * $this->product[$key]['product_subtotal'] : null;
        } elseif ($this->tax_type == 2) {
            $this->product[$key]['cgstamt'] = $this->product[$key]['product_quantity'] ? ($this->product[$key]['cgst'] / 100) * $this->product[$key]['product_subtotal'] : null;
            $this->product[$key]['sgstamt'] = $this->product[$key]['product_quantity'] ? ($this->product[$key]['sgst'] / 100) * $this->product[$key]['product_subtotal'] : null;
            $this->product[$key]['igstamt'] = $this->product[$key]['product_quantity'] ? ($this->product[$key]['igst'] / 100) * $this->product[$key]['product_subtotal'] : null;
            $this->product[$key]['cessamt'] = $this->product[$key]['product_quantity'] ? ($this->product[$key]['cess'] / 100) * $this->product[$key]['product_subtotal'] : null;
        }
        $this->overallcalc();

    }

    public function removeitem($key)
    {
        if ($this->purchase) {
            Purchaseitem::where('purchase_id', $this->purchase)
                ->where('product_id', $this->product[$key]['product_id'])
                ->delete();
        }
        unset($this->product[$key]);
        $this->overallcalc();

        $this->submitbutton = false;
    }

    public function overallcalc()
    {
        $this->form['sub_total'] = collect($this->product)->pluck('product_subtotal')->sum();
        $this->form['taxableamt'] = collect($this->product)->pluck('product_subtotal')->sum();
        if ($this->tax_type == 3) {
            $this->form['vat'] = collect($this->product)->pluck('vatamt')->sum();
            $this->form['taxamt'] = collect($this->product)->pluck('vatamt')->sum();
        } elseif ($this->tax_type == 2) {
            $this->form['cgst'] = collect($this->product)->pluck('cgstamt')->sum();
            $this->form['sgst'] = collect($this->product)->pluck('sgstamt')->sum();
            $this->form['igst'] = collect($this->product)->pluck('igstamt')->sum();
            $this->form['cess'] = collect($this->product)->pluck('cessamt')->sum();
            $this->form['taxamt'] = $this->form['cgst'] + $this->form['sgst'] + $this->form['igst'] + $this->form['cess'];
        }
        $this->form['total'] = $this->form['sub_total']
             + ($this->form['freight_charges'] ? $this->form['freight_charges'] : 0)
             + ($this->form['adjustment'] ? $this->form['adjustment'] : 0)
             - ($this->form['discount'] ? $this->form['discount'] : 0);

        $this->form['total_items'] = count($this->product);
        $this->form['roundoff'] = round($this->form['total']) - $this->form['total'];
        if ($this->tax_type == 1) {
            $this->form['grandtotal'] = round($this->form['total']);
        } elseif ($this->tax_type == 3) {
            $this->form['grandtotal'] = round($this->form['total']) + $this->form['vat'];
            $this->form['grandtotal'] = number_format((float) $this->form['grandtotal'], 2, '.', '');
        } elseif ($this->tax_type == 2) {
            $this->form['grandtotal'] = round($this->form['total']) + $this->form['cgst'] + $this->form['sgst'] + $this->form['igst'] + $this->form['cess'];
            $this->form['grandtotal'] = number_format((float) $this->form['grandtotal'], 2, '.', '');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.purchase.purchasecreateoreditlivewire');
    }
}
