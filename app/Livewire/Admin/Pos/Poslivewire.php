<?php

namespace App\Livewire\Admin\Pos;

use App\Livewire\Admin\Pos\Possalecreditordebitlivewire;
use App\Livewire\Admin\Pos\Possalecustomerlivewire;
use App\Livewire\Admin\Pos\Possaledatatablelivewire;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Salehold\Salehold;
use App\Models\Admin\Salehold\Saleholditem;
use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Sale\Saleitem;
use App\Models\Admin\Settings\Mastersettings\Productcategory;
use App\Models\Miscellaneous\Trackmessagehelper;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Poslivewire extends Component
{
    use miscellaneousLivewireTrait, Possaledatatablelivewire,
    Possalecustomerlivewire, Possalecreditordebitlivewire;
    public $salehold_id;
    public $reference_id, $tax_type;
    public $formdata = [
        'customer_id' => null,
        'customer_name' => null,
        'customer_phone' => null,

        'received_amount' => 0,
        'remaining_amount' => 0,
        'sub_total' => 0,
        'discount' => 0,
        'total_items' => 0,
        'total' => 0,
        'extra_charges' => 0,
        'grandtotal' => 0,
        'taxamt' => null,
        'taxableamt' => null,
        'cgst' => null,
        'cgst' => null,
        'sgst' => null,
        'vat' => null,
        'roundoff' => 0,
        'mode' => 0,
    ];

    public $sale;

    public $productlist = [];
    public $productcategory_id = 0;

    protected $listeners = ['formreset'];

    protected function rules(): array
    {
        return [
            'productlist' => 'required',
            'productlist.*.product_id' => 'required|integer',
            'productlist.*.product_name' => 'required|string',
            'productlist.*.product_rate' => 'required|min:1',
            'productlist.*.product_quantity' => 'required|integer|min:1',
            'productlist.*.product_subtotal' => 'required',
            'productlist.*.product_sellingprice' => 'required',
            'productlist.*.taxamt' => 'nullable|required_if:tax_type,2,3',
            'productlist.*.taxable' => 'nullable|required_if:tax_type,2,3',
            'productlist.*.cgst' => 'nullable|required_if:tax_type,==,2',
            'productlist.*.cgstamt' => 'nullable|required_if:tax_type,==,2',
            'productlist.*.sgst' => 'nullable|required_if:tax_type,==,2',
            'productlist.*.sgstamt' => 'nullable|required_if:tax_type,==,2',
            'productlist.*.vat' => 'nullable|required_if:tax_type,==,3',
            'productlist.*.vatamt' => 'nullable|required_if:tax_type,==,3',

            'form.customer_name' => 'nullable|string|min:2|max:70',
            'form.customer_id' => 'nullable|integer',
            'form.customer_phone' => 'nullable|digits:10',

            'form.total_items' => 'required|integer',
            'form.mode' => 'required|integer|min:1|max:3',
            'form.sub_total' => 'required|numeric',
            'form.received_amount' => 'required|numeric|not_in:0',
            'form.remaining_amount' => 'required|numeric',
            'form.extra_charges' => 'nullable|numeric',
            'form.roundoff' => 'required',
            'form.discount' => 'nullable|numeric',
            'form.total' => 'required|numeric',
            'form.taxamt' => 'nullable|required_if:tax_type,2,3',
            'form.taxableamt' => 'nullable|required_if:tax_type,2,3',
            'form.cgst' => 'nullable|required_if:tax_type,==,2',
            'form.sgst' => 'nullable|required_if:tax_type,==,2',
            'form.vat' => 'nullable|required_if:tax_type,==,3',
            'form.grandtotal' => 'required|numeric',

        ];
    }

    protected $messages = [
        'productlist.*.product_id.required' => 'Product ID is Required',
        'productlist.*.product_name.required' => 'Name is Required',
        'productlist.*.product_rate.required' => 'Required',
        'productlist.*.product_quantity.required' => 'Quantity is Required',
        'productlist.*.product_quantity.min' => 'Quantity is Invalid',
        'productlist.*.product_subtotal.required' => 'Subtotal is Required',
        'productlist.*.product_purchaseprice.required' => 'Purchase Price is Required',
        'productlist.*.product_sellingprice.required' => 'Actual Price is Required',
        'productlist' => 'Please Add a Product',

        'form.customer_phone' => 'Phone must be 10 digits',
        'form.total_items' => 'Total items is required',
        'form.received_amount' => 'Recieved Amount must be Greater than or Equal to Total Amount',
        'form.total' => 'required',
    ];

    public function mount($id, $type): void
    {
        $this->tax_type = App::make('possetting')->tax_type;
        if ($id && $type == 'sale') {
            $this->sale = Sale::with('saleitem', 'customer')->find($id);

            foreach ($this->sale->saleitem as $key => $eachsaleitem) {
                array_push($this->productlist,
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

            if ($this->sale->customer) {
                $this->customer = $this->sale->customer;
                $this->customerphone = $this->sale->customer->phone;
                $this->form['customer_id'] = $this->sale->customer_id;
                $this->form['customer_name'] = $this->sale->customer->name;
                $this->form['customer_email'] = $this->sale->customer->email;
            }
        } elseif ($id && $type == 'hold') {
            $this->salehold_id = $id;
            $salehold = Salehold::find($id);
            foreach ($salehold->saleholditem as $key => $eachsaleholditem) {
                $product = Product::find($eachsaleholditem->product_id);
                array_push($this->productlist,
                    [
                        'product_saleitemid' => null,
                        'product_id' => $eachsaleholditem->product_id,
                        'product_name' => $product->name,
                        'product_quantity' => $eachsaleholditem->quantity,
                        'product_rate' => $product->sellingprice,
                        'product_subtotal' => $product->sellingprice * $eachsaleholditem->quantity,
                        'product_purchaseprice' => $product->purchaseprice,
                        'product_sellingprice' => $product->sellingprice,
                        'product_stock' => $product->stock,
                    ]);
            }
            $this->form = $this->formdata;

            $this->form['customer_id'] = $salehold->customer_id;
            $this->form['customer_name'] = $salehold->customer_name;
            $this->form['customer_phone'] = $salehold->customer_phone;
            $this->form['customer_email'] = $salehold?->customer?->email;
            $this->customer = $this->sale->customer;
            $this->overallcalc();
        } else {
            $this->form = $this->formdata;
        }
    }

    public function onclickproduct(Product $product)
    {
        $existingproduct = collect($this->productlist)->where('product_id', $product->id)->keys();

        if ($existingproduct->count() > 0) {

            $this->productlist[$existingproduct[0]]['product_quantity'] += 1;
            $this->productlist[$existingproduct[0]]['product_subtotal'] = $this->productlist[$existingproduct[0]]['product_quantity'] * $this->productlist[$existingproduct[0]]['product_rate'];
            if ($this->tax_type == 3) {
                $this->productlist[$existingproduct[0]]['vatamt'] = $this->productlist[$existingproduct[0]]['product_quantity'] ? ($this->productlist[$existingproduct[0]]['vat'] / 100) * $this->productlist[$existingproduct[0]]['product_subtotal'] : null;
            } elseif ($this->tax_type == 2) {
                $this->productlist[$existingproduct[0]]['cgstamt'] = $this->productlist[$existingproduct[0]]['product_quantity'] ? ($this->productlist[$existingproduct[0]]['cgst'] / 100) * $this->productlist[$existingproduct[0]]['product_subtotal'] : null;
                $this->productlist[$existingproduct[0]]['sgstamt'] = $this->productlist[$existingproduct[0]]['product_quantity'] ? ($this->productlist[$existingproduct[0]]['sgst'] / 100) * $this->productlist[$existingproduct[0]]['product_subtotal'] : null;
            }
        } else {
            array_push($this->productlist,
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
        }
        $this->searchTerm = '';
        $this->overallcalc();
    }

    public function additem($key)
    {
        $this->productlist[$key]['product_quantity'] += 1;
        $this->productlist[$key]['product_subtotal'] = $this->productlist[$key]['product_quantity'] * $this->productlist[$key]['product_rate'];
        if ($this->tax_type == 3) {
            $this->productlist[$key]['vatamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['vat'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
        } elseif ($this->tax_type == 2) {
            $this->productlist[$key]['cgstamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['cgst'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
            $this->productlist[$key]['sgstamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['sgst'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
        }
        $this->overallcalc();
    }

    public function storesale()
    {

        $validatedData = $this->validate();
        try {

            DB::beginTransaction();
            if (!$this->customer && $validatedData['form']['customer_name']) {
                $validatedData['form']['customer_phone'] = $this->customerphone;
                $customer = Customer::create([
                    'name' => $validatedData['form']['customer_name'],
                    'phone' => $validatedData['form']['customer_phone'],
                ]);
                $validatedData['form']['customer_id'] = $customer->id;
            }

            $sale = $this->sale ? $this->updatesale($validatedData) : $this->createsale($validatedData);
            DB::commit();

            $this->formreset();
            $this->submitbutton = true;

        } catch (Exception $e) {
            $this->exceptionerror(auth()->user(), 'admin_salepos_createoredit', 'error_one : ' . $e->getMessage());
        } catch (QueryException $e) {
            $this->exceptionerror(auth()->user(), 'admin_salepos_createoredit', 'error_two : ' . $e->getMessage());
        } catch (PDOException $e) {
            $this->exceptionerror(auth()->user(), 'admin_salepos_createoredit', 'error_three : ' . $e->getMessage());
        }
    }

    protected function updatesale($data)
    {
        $saledata = $this->sale;
        $this->amountcreditanddebit($saledata, 'UPDATE');
        $this->sale->update($data['form']);

        foreach ($data['productlist'] as $key => $updateproduct) {
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
        Trackmessagehelper::trackmessage(auth()->user(), $this->sale, 'saleupdatepos', session()->getId(), 'WEB', 'Sale POS was Updated');
    }

    protected function createsale($data)
    {
        $data['form']['source_type'] = 1;
        $sale = Sale::create($data['form']);
        $this->amountcreditanddebit($sale, 'CREATE');

        foreach ($data['productlist'] as $key => $storeproduct) {
            $this->stockcreditanddebit($sale, $storeproduct);
            $sale->saleitem()
                ->create([
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
        Trackmessagehelper::trackmessage(auth()->user(), $sale, 'salecreatepos', session()->getId(), 'WEB', 'Sale POS Created');
        $this->print($sale->id);
    }

    public function storeholdsale()
    {
        $this->validate([
            'productlist' => 'required|array',
            'reference_id' => 'required|string|min:3',
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
                foreach ($this->productlist as $key => $updateproduct) {
                    $salehold
                        ->saleitem()
                        ->updateOrCreate(
                            ['salehold_id' => $this->salehold_id, 'product_id' => $updateproduct['product_id'], 'reference_id' => $this->reference_id],
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
                foreach ($this->productlist as $key => $storeproduct) {
                    $salehold->saleholditem()->create([
                        'product_id' => $storeproduct['product_id'],
                        'product_name' => $storeproduct['product_name'],
                        'quantity' => $storeproduct['product_quantity'],
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('salepos');
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
            'productlist' => 'required|array',
        ]);
        $this->dispatch('holdsalemodal');
    }

    protected function databind($saleid, $type): void
    {
        $this->showdata = Sale::with('saleitem', 'customer')->find($saleid);
    }

    public function pagerefresh()
    {
        return redirect()->route('salepos');
    }

    public function print($printid)
    {
        $this->databind($printid, 'print');
        $this->dispatch('printmodal');
    }

    public function subitem($key)
    {
        $this->productlist[$key]['product_quantity'] -= 1;
        if ($this->productlist[$key]['product_quantity'] < 1) {
            $this->productlist[$key]['product_quantity'] = 1;

            $this->productlist[$key]['product_subtotal'] = $this->productlist[$key]['product_quantity'] * $this->productlist[$key]['product_rate'];
        }
        $this->productlist[$key]['product_subtotal'] = $this->productlist[$key]['product_quantity'] * $this->productlist[$key]['product_rate'];
        if ($this->tax_type == 3) {
            $this->productlist[$key]['vatamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['vat'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
        } elseif ($this->tax_type == 2) {
            $this->productlist[$key]['cgstamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['cgst'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
            $this->productlist[$key]['sgstamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['sgst'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
        }
        $this->overallcalc();
    }

    public function removeitem($key, $salesitemid)
    {
        ($salesitemid) ? Saleitem::find($salesitemid)->delete() : null;
        unset($this->productlist[$key]);
        $this->overallcalc();
    }

    public function productcalculation($key)
    {
        $this->productlist[$key]['product_subtotal'] = ($this->productlist[$key]['product_quantity'] ? $this->productlist[$key]['product_quantity'] : 0)
             * ($this->productlist[$key]['product_rate'] ? $this->productlist[$key]['product_rate'] : 0);
        if ($this->tax_type == 3) {
            $this->productlist[$key]['vatamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['vat'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
        } elseif ($this->tax_type == 2) {
            $this->productlist[$key]['cgstamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['cgst'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
            $this->productlist[$key]['sgstamt'] = $this->productlist[$key]['product_quantity'] ? ($this->productlist[$key]['sgst'] / 100) * $this->productlist[$key]['product_subtotal'] : null;
        }
        $this->overallcalc();
    }

    public function submit($mode)
    {
        $this->form['mode'] = $mode;
        $this->storesale();
    }

    public function overallcalc()
    {

        $this->form['sub_total'] = collect($this->productlist)->pluck('product_subtotal')->sum();
        $this->form['taxableamt'] = collect($this->productlist)->pluck('product_subtotal')->sum();
        if ($this->tax_type == 3) {
            $this->form['vat'] = collect($this->productlist)->pluck('vatamt')->sum();
            $this->form['taxamt'] = collect($this->productlist)->pluck('vatamt')->sum();
        } elseif ($this->tax_type == 2) {

            $this->form['cgst'] = collect($this->productlist)->pluck('cgstamt')->sum();
            $this->form['sgst'] = collect($this->productlist)->pluck('sgstamt')->sum();
            $this->form['taxamt'] = $this->form['cgst'] + $this->form['sgst'];
        }

        $this->form['total'] = $this->form['sub_total']
             + ($this->form['extra_charges'] ? $this->form['extra_charges'] : 0)
             - ($this->form['discount'] ? $this->form['discount'] : 0);

        $this->form['total_items'] = count($this->productlist);
        if ($this->tax_type == 1) {
            $this->form['grandtotal'] = round($this->form['total']);
        } elseif ($this->tax_type == 3) {
            $this->form['grandtotal'] = round($this->form['total']) + $this->form['vat'];
            $this->form['grandtotal'] = number_format((float) $this->form['grandtotal'], 2, '.', '');
        } elseif ($this->tax_type == 2) {
            $this->form['grandtotal'] = round($this->form['total']) + $this->form['cgst'] + $this->form['sgst'];
            $this->form['grandtotal'] = number_format((float) $this->form['grandtotal'], 2, '.', '');
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
            $this->form['remaining_amount'] = $this->form['received_amount'] - $this->form['grandtotal']; // -minus red color , plus green color
        }
    }

    #[Computed]
    public function product()
    {
        if (App::make('possetting')->theme == 1) {
            $gridsize = 16;
        } elseif (App::make('possetting')->theme == 2) {
            $gridsize = 20;
        } elseif (App::make('possetting')->theme == 3) {
            $gridsize = 24;
        }

        return Product::query()
            ->where('active', true)
            ->when($this->productcategory_id, fn($q) => $q->where("productcategory_id", $this->productcategory_id))
            ->where(fn($query) =>
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('productcategory', fn($q) => $q->where('name', 'like', '%' . $this->searchTerm . '%'))
            )
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate($gridsize)
            ->onEachSide(1);
    }

    #[Computed]
    public function productcategory()
    {
        return Productcategory::where('active', true)
            ->pluck('name', 'id');
    }

    public function render(): View
    {
        return view('livewire.admin.pos.poslivewire');
    }
}
