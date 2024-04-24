<?php

namespace App\Livewire\Admin\Sale;

use App\Livewire\Admin\Sale\Salecreditordebitlivewire;
use App\Livewire\Admin\Sale\Salecustomerlivewire;
use App\Livewire\Livewirehelper\Datatable\datatableLivewireTrait;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Salehold\Salehold;
use App\Models\Admin\Salehold\Saleholditem;
use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Sale\Saleitem;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Component;

class Salecreateoreditlivewire extends Component
{
    use miscellaneousLivewireTrait, datatableLivewireTrait,
    Salecustomerlivewire, Salecreditordebitlivewire;
    public $salehold_id;
    public $reference_id, $tax_type;
    public $formdata = [

        'customer_id' => null,
        'customer_name' => null,
        'customer_phone' => null,
        'customer_email' => null,

        'received_amount' => 0,
        'remaining_amount' => 0,
        'sub_total' => 0,
        'discount' => 0,
        'total_items' => 0,
        'total' => 0,
        'extra_charges' => 0,
        'note' => '',
        'roundoff' => 0,
        'grandtotal' => 0,
        'taxamt' => null,
        'taxableamt' => null,
        'cgst' => null,
        'cgst' => null,
        'sgst' => null,
        'vat' => null,
        'mode' => 0,
    ];

    // sale

    public $sale, $salehold;

    // Product

    public $product_selected;
    public $product = [];
    public $searchproductlist = [];

    public $highlightIndex = 0;

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
            'product.*.product_sellingprice' => 'required',
            'product.*.product_sellingprice' => 'required',
            'product.*.product_sellingprice' => 'required',
            'product.*.product_sellingprice' => 'required',
            'product.*.taxamt' => 'nullable|required_if:tax_type,2,3',
            'product.*.taxable' => 'nullable|required_if:tax_type,2,3',
            'product.*.cgst' => 'nullable|required_if:tax_type,==,2',
            'product.*.cgstamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.sgst' => 'nullable|required_if:tax_type,==,2',
            'product.*.sgstamt' => 'nullable|required_if:tax_type,==,2',
            'product.*.vat' => 'nullable|required_if:tax_type,==,3',
            'product.*.vatamt' => 'nullable|required_if:tax_type,==,3',

            'form.customer_id' => 'nullable|integer',
            'form.customer_phone' => 'nullable|digits:10',

            'form.customer_name' => 'nullable|string|min:2|max:70',

            'form.customer_email' => 'nullable|email',

            'form.sub_total' => 'required',
            'form.received_amount' => 'required|not_in:0',
            'form.remaining_amount' => 'required',
            'form.extra_charges' => 'nullable',
            'form.discount' => 'nullable',
            'form.total_items' => 'nullable',
            'form.total' => 'required|numeric',
            'form.roundoff' => 'required',
            'form.taxamt' => 'nullable|required_if:tax_type,2,3',
            'form.taxableamt' => 'nullable|required_if:tax_type,2,3',
            'form.cgst' => 'nullable|required_if:tax_type,==,2',
            'form.sgst' => 'nullable|required_if:tax_type,==,2',
            'form.vat' => 'nullable|required_if:tax_type,==,3',
            'form.grandtotal' => 'required',
            'form.mode' => 'required|integer|min:1|max:3',

            'form.note' => 'nullable|min:5|max:255',
        ];
    }

    protected $messages = [

        'product.*.product_id.required' => 'Product ID is Required',
        'product.*.product_name.required' => 'Name is Required',
        'product.*.product_rate.required' => 'Rate is Required',
        'product.*.product_quantity.required' => 'Quantity is Required',
        'product.*.product_quantity.min' => 'Quantity is Invalid',
        'product.*.product_subtotal.required' => 'Subtotal is Required',
        'product.*.product_purchaseprice.required' => 'Purchase Price is Required',
        'product.*.product_sellingprice.required' => 'Actual Price is Required',
        'product.*.product_quantity.lte' => 'Product out of stock',
        'product' => 'Please Add a Product',

        'form.received_amount.not_in' => 'Recieved Amount must be Greater than or Equal to Total Amount',
        'form.total' => 'required',

    ];

    public function mount($id, $type): void
    {
        $this->tax_type = App::make('possetting')->tax_type;
        if ($id && $type == 'sale') {
            $this->sale = Sale::with('saleitem')->find($id);

            foreach ($this->sale->saleitem as $key => $eachsaleitem) {
                $product = Product::find($eachsaleitem->product_id);
                array_push($this->product,
                    [
                        'product_saleitemid' => $eachsaleitem->id,
                        'product_id' => $eachsaleitem->product_id,
                        'product_name' => $eachsaleitem->product_name,
                        'product_quantity' => $eachsaleitem->quantity,
                        'product_rate' => $eachsaleitem->price,
                        'product_subtotal' => $eachsaleitem->total,
                        'product_purchaseprice' => $eachsaleitem->purchaseprice,
                        'product_sellingprice' => $eachsaleitem->sellingprice,
                        'taxamt' => $eachsaleitem->taxamt,
                        'taxable' => $eachsaleitem->taxable,
                        'cgst' => $eachsaleitem->cgst,
                        'cgstamt' => $eachsaleitem->cgstamt,
                        'sgst' => $eachsaleitem->sgst,
                        'sgstamt' => $eachsaleitem->sgstamt,
                        'vat' => $eachsaleitem->vat,
                        'vatamt' => $eachsaleitem->vatamt,
                        'product_stock' => $product->stock,
                    ]);
            }
            $this->form = $this->sale->only('received_amount', 'remaining_amount', 'sub_total', 'discount', 'total_items', 'total', 'extra_charges', 'note', 'roundoff', 'grandtotal', 'mode', 'taxamt', 'taxableamt', 'cgst', 'sgst', 'vat');
            if ($this->sale->customer_id) {
                $customer = Customer::find($this->sale->customer_id);

                $this->customerphone = $customer->phone;
                $this->form['customer_name'] = $customer->name;
                $this->form['customer_email'] = $customer->email;
            }

        } elseif ($id && $type == 'hold') {
            $this->salehold_id = $id;
            $this->salehold = Salehold::find($id);
            foreach ($this->salehold->saleholditem as $key => $eachsaleholditem) {
                $product = Product::find($eachsaleholditem->product_id);
                array_push($this->product,
                    [
                        'product_saleitemid' => null,
                        'product_id' => $eachsaleholditem->product_id,
                        'product_name' => $product->name,
                        'product_quantity' => $eachsaleholditem->quantity,
                        'product_rate' => $product->sellingprice,
                        'product_subtotal' => $product->sellingprice * $eachsaleholditem->quantity,
                        'product_purchaseprice' => $product->purchaseprice,
                        'product_sellingprice' => $product->sellingprice,
                        'taxable' => $product->sellingprice * $eachsaleholditem->quantity,
                        'vat' => $this->tax_type == 3 && $product->vat ? $product->vat : null,
                        'vatamt' => $this->tax_type == 3 && $product->vat ? ($product->vat / 100) * ($product->sellingprice * $eachsaleholditem->quantity) : null,
                        'cgst' => $this->tax_type == 2 && $product->cgst ? $product->cgst : null,
                        'cgstamt' => $this->tax_type == 2 && $product->cgst ? ($product->cgst / 100) * ($product->sellingprice * $eachsaleholditem->quantity) : null,
                        'sgst' => $this->tax_type == 2 && $product->sgst ? $product->sgst : null,
                        'sgstamt' => $this->tax_type == 2 && $product->sgst ? ($product->sgst / 100) * ($product->sellingprice * $eachsaleholditem->quantity) : null,
                        'taxamt' => $this->tax_type == 3 ? (($product->vat / 100) * ($product->sellingprice * $eachsaleholditem->quantity)) : ($this->tax_type == 2 ? ((($product->cgst / 100) * ($product->sellingprice * $eachsaleholditem->quantity)) + (($product->sgst / 100) * ($product->sellingprice * $eachsaleholditem->quantity))) : null),
                        'product_stock' => $product->stock,

                        'hsn' => $product->hsn,
                    ]);
            }
            $this->form = $this->formdata;

            $this->form['customer_id'] = $this->salehold->customer_id;
            $this->form['customer_name'] = $this->salehold->customer_name;
            $this->form['customer_phone'] = $this->salehold->customer_phone;
            $this->form['customer_email'] = $this->salehold?->customer?->email;
            $this->customerphone = $this->salehold?->customer?->phone;
            $this->overallcalc();
        } else {
            $this->form = $this->formdata;
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

    protected function updatesale($data): void
    {

        $saledata = $this->sale;
        $this->amountcreditanddebit($saledata, 'UPDATE');
        $this->sale->update($data['form']);

        foreach ($data['product'] as $key => $updateproduct) {
            $this->stockcreditanddebit($saledata, $updateproduct);
            $this->sale
                ->saleitem()
                ->updateOrCreate(
                    ['sale_id' => $this->sale->id, 'product_id' => $updateproduct['product_id']],
                    [
                        'product_name' => $updateproduct['product_name'],
                        'quantity' => $updateproduct['product_quantity'],
                        'returnable_quantity' => $updateproduct['product_quantity'],
                        'price' => $updateproduct['product_rate'],
                        'total' => $updateproduct['product_subtotal'],
                        'purchaseprice' => $updateproduct['product_purchaseprice'],
                        'sellingprice' => $updateproduct['product_sellingprice'],
                        'taxamt' => $updateproduct['taxamt'],
                        'taxable' => $updateproduct['taxable'],
                        'cgst' => $updateproduct['cgst'],
                        'cgstamt' => $updateproduct['cgstamt'],
                        'sgst' => $updateproduct['sgst'],
                        'sgstamt' => $updateproduct['sgstamt'],
                        'vat' => $updateproduct['vat'],
                        'vatamt' => $updateproduct['vatamt'],
                        'grandtotal' => $updateproduct['product_subtotal'] + $updateproduct['taxamt'],
                    ]
                );
        }
        Trackmessagehelper::trackmessage(auth()->user(), $this->sale, 'salecreateoredit', session()->getId(), 'WEB', 'Sale was Updated');
        $this->toaster('success', 'Sale was Updated Successfully!!');
    }

    protected function createsale($data): void
    {
        $sale = Sale::create($data['form']);
        $this->amountcreditanddebit($sale, 'CREATE');
        foreach ($data['product'] as $key => $storeproduct) {
            $this->stockcreditanddebit($sale, $storeproduct);
            $sale->saleitem()->create([
                'product_id' => $storeproduct['product_id'],
                'product_name' => $storeproduct['product_name'],
                'purchaseprice' => $storeproduct['product_purchaseprice'],
                'sellingprice' => $storeproduct['product_sellingprice'],
                'price' => $storeproduct['product_rate'],
                'quantity' => $storeproduct['product_quantity'],
                'returnable_quantity' => $storeproduct['product_quantity'],
                'total' => $storeproduct['product_rate'] * $storeproduct['product_quantity'],
                'total' => $storeproduct['product_rate'] * $storeproduct['product_quantity'],
                'taxamt' => $storeproduct['taxamt'],
                'taxable' => $storeproduct['taxable'],
                'cgst' => $storeproduct['cgst'],
                'cgstamt' => $storeproduct['cgstamt'],
                'sgst' => $storeproduct['sgst'],
                'sgstamt' => $storeproduct['sgstamt'],
                'vat' => $storeproduct['vat'],
                'vatamt' => $storeproduct['vatamt'],
                'grandtotal' => $storeproduct['product_subtotal'] + $storeproduct['taxamt'],
            ]);
        }
        if ($this->salehold_id) {
            Saleholditem::where('salehold_id', $this->salehold_id)->delete();
            Salehold::find($this->salehold_id)->delete();
        }
        Trackmessagehelper::trackmessage(auth()->user(), $sale, 'salecreateoredit', session()->getId(), 'WEB', 'Sale Created');
        $this->toaster('success', 'Sale Created Successfully!!');
    }

    public function storesale(): Redirector
    {
        $validatedData = $this->validate();
        try {

            DB::beginTransaction();
            $this->sale ? $this->updatesale($validatedData) : $this->createsale($validatedData);
            DB::commit();
            return redirect()->route('adminsale');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_sales_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_sales_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_sales_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    public function storeholdsale()
    {
        $reference_id = App::make('possetting')->is_hold && App::make('possetting')->is_holdreference ? true : false;
        $this->validate([
            'product' => 'required|array',
            'reference_id' => $reference_id ? 'required|string|min:3' : 'nullable',
        ]);
        try {
            DB::beginTransaction();
            if ($this->salehold_id) {
                $salehold = Salehold::find($this->salehold_id);
                $salehold->update([
                    'customer_id' => $this->form['customer_id'],
                    'customer_name' => $this->form['customer_name'],
                    'customer_phone' => $this->form['customer_phone'],
                    'reference_id' => $this->reference_id,
                ]);
                foreach ($this->product as $key => $updateproduct) {
                    $salehold
                        ->saleholditem()
                        ->updateOrCreate(
                            ['salehold_id' => $this->salehold_id, 'product_id' => $updateproduct['product_id']],
                            [
                                'product_name' => $updateproduct['product_name'],
                                'quantity' => $updateproduct['product_quantity'],
                            ]
                        );
                }
            } else {
                $salehold = Salehold::create([
                    'customer_id' => $this->form['customer_id'],
                    'customer_name' => $this->form['customer_name'],
                    'customer_phone' => $this->form['customer_phone'],
                    'reference_id' => $this->reference_id,
                ]);
                foreach ($this->product as $key => $storeproduct) {
                    $salehold->saleholditem()->create([
                        'product_id' => $storeproduct['product_id'],
                        'product_name' => $storeproduct['product_name'],
                        'quantity' => $storeproduct['product_quantity'],
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('adminsale');
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_sales_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_sales_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_sales_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    public function holdsale()
    {
        $this->validate([
            'product' => 'required|array',
        ]);
        $this->dispatch('holdsalemodal');
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
                'product_saleitemid' => null,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_quantity' => 1,
                'product_rate' => $product->sellingprice,
                'product_subtotal' => $product->sellingprice,
                'product_purchaseprice' => $product->purchaseprice,
                'product_sellingprice' => $product->sellingprice,
                'product_stock' => $product->stock,
                'vat' => $this->tax_type == 3 && $product->vat ? $product->vat : null,
                'vatamt' => $this->tax_type == 3 && $product->vat ? ($product->vat / 100) * $product->sellingprice : null,
                'cgst' => $this->tax_type == 2 && $product->cgst ? $product->cgst : null,
                'cgstamt' => $this->tax_type == 2 && $product->cgst ? ($product->cgst / 100) * $product->sellingprice : null,
                'sgst' => $this->tax_type == 2 && $product->sgst ? $product->sgst : null,
                'sgstamt' => $this->tax_type == 2 && $product->sgst ? ($product->sgst / 100) * $product->sellingprice : null,
                'taxable' => $product->sellingprice,
                'taxamt' => $this->tax_type == 3 ? (($product->vat / 100) * $product->sellingprice) : ($this->tax_type == 2 ? ((($product->cgst / 100) * $product->sellingprice) + (($product->sgst / 100) * $product->sellingprice)) : null),
                'hsn' => $product->hsn,
            ]);
        $this->product_selected = '';
        $this->searchproductlist = [];
        $this->overallcalc();

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
        }
        $this->overallcalc();

    }

    public function removeitem($key)
    {
        if ($this->sale) {
            Saleitem::where('sale_id', $this->sale->id)
                ->where('product_id', $this->product[$key]['product_id'])
                ->delete();
        }
        if ($this->salehold) {
            Saleholditem::where('salehold_id', $this->salehold->id)
                ->where('product_id', $this->product[$key]['product_id'])
                ->delete();
        }
        unset($this->product[$key]);
        $this->overallcalc();

        $this->submitbutton = false;
    }

    public function submit($mode)
    {

        $this->form['mode'] = $mode;
        $this->storesale();
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
            $this->form['taxamt'] = $this->form['cgst'] + $this->form['sgst'];
        }
        $this->form['total'] = $this->form['sub_total']
             + ($this->form['extra_charges'] ? $this->form['extra_charges'] : 0)
             - ($this->form['discount'] ? $this->form['discount'] : 0);

        $this->form['total_items'] = count($this->product);

        if ($this->tax_type == 1) {
            $this->form['grandtotal'] = $this->form['total'];
        } elseif ($this->tax_type == 3) {
            $this->form['grandtotal'] = $this->form['total'] + $this->form['vat'];
        } elseif ($this->tax_type == 2) {
            $this->form['grandtotal'] = $this->form['total'] + $this->form['cgst'] + $this->form['sgst'];
        }
        $this->form['grandtotal'] = number_format((float) ($this->form['grandtotal']), 2, '.', '');
        $whole = floor($this->form['grandtotal']);
        $fraction = $this->form['grandtotal'] - $whole;
        if ($fraction > 0.49) {
            $this->form['roundoff'] = 1 - $fraction;
            $this->form['grandtotal'] = $whole + 1;
        } else {
            $this->form['roundoff'] = $fraction;
            $this->form['grandtotal'] = $whole;
        }
        if ($this->form['received_amount'] != '') {
            $this->form['remaining_amount'] = $this->form['received_amount'] - $this->form['grandtotal'];
        }
    }

    public function render(): view
    {
        return view('livewire.admin.sale.salecreateoreditlivewire');
    }
}
