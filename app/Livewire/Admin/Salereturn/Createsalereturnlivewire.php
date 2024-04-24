<?php

namespace App\Livewire\Admin\Salereturn;

use Livewire\Component;
use App\Models\Admin\Sale\Sale;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Sale\Saleitem;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Salereturn\Salereturn;
use App\Models\Admin\Salereturn\Salereturnitem;
use App\Livewire\Admin\Sale\Salecustomerlivewire;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;

class Createsalereturnlivewire extends Component
{
    use miscellaneousLivewireTrait, Salecustomerlivewire;

    public $customer, $customerlist, $highlightIndex, $iscustomerselected = false, $customer_id, $customerselected,
    $required, $tax_type;
    public $sale, $saleid, $salelist, $salehighlightIndex, $issaleselected = false;
    public $debit_amount, $return_note, $submitbtn = true;
    public $salereturitem = [];
    protected $listeners = ['resetData'];

    public function mount($id)
    {
        $this->tax_type = App::make('possetting')->tax_type;
        $this->resetData();
        if ($id) {
            $sale = Sale::find($id);
            if ($sale->customer_id) {
                $this->iscustomerselected = true;
                $this->customer_id = $sale->customer_id;
                $this->customerselected = Customer::find($sale->customer_id);
            }
            $this->issaleselected = true;
            $this->sale = $sale->uniqid;
            $this->saleid = $id;
            $this->loadsalesitems();

        }
    }

    public function rules()
    {
        return [
            'return_note' => 'required|min:3|max:255',

            'salereturitem' => 'required|array',
            'salereturitem.*.return_quantity' => ['nullable','required_if:salereturitem.*.is_selected,==,true','lte:salereturitem.*.returnable_quantity','lte:salereturitem.*.quantity'],
        ];
    }

    public function messages()
    {
        return [
            'salereturitem.*.return_quantity.required_if' => 'Enter Quantity',
            'salereturitem.*.return_quantity.lte' => 'Return Quantity Exceeds',
            'salereturitem.*.quantity.lte' => 'Return Quantity Exceeds',
        ];
    }

    public function resetData()
    {
        $this->customerlist = [];
        $this->sale = '';
        $this->salelist = [];
        $this->highlightIndex = 0;
        $this->salehighlightIndex = 0;
        $this->loadsalesitems();
        $this->salereturitem = [];
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->customerlist) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->customerlist) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function saleincrementHighlight()
    {
        if ($this->salehighlightIndex === count($this->salelist) - 1) {
            $this->salehighlightIndex = 0;
            return;
        }
        $this->salehighlightIndex++;
    }

    public function saledecrementHighlight()
    {
        if ($this->salehighlightIndex === 0) {
            $this->salehighlightIndex = count($this->salelist) - 1;
            return;
        }
        $this->salehighlightIndex--;
    }

    public function updatedCustomer()
    {
        $this->iscustomerselected = false;
        if ($this->customer) {
            $this->resetData();
            $this->customerlist = Customer::where(function ($customer) {
                $customer->where('name', 'like', '%' . $this->customer . '%')
                    ->orWhere('phone', 'like', '%' . $this->customer . '%');
            })
                ->get();
        } else {
            $this->resetData();
        }
    }

    public function selectCustomer()
    {
        $customer = $this->customerlist[$this->highlightIndex] ?? null;
        if ($customer) {
            $higlightcustomer = $this->customerlist[$this->highlightIndex];
            $this->selecthiscustomer($higlightcustomer->id, $higlightcustomer->phone, $higlightcustomer->name);
        }
    }

    public function selecthiscustomer($id, $phone, $name)
    {
        $this->iscustomerselected = true;
        $this->customer = null;
        $this->customer_id = $id;
        $this->customerselected = Customer::find($id);
    }

    public function updatedSale()
    {
        $this->issaleselected = false;
        $this->salelist = Sale::where('customer_id', $this->customer_id)
            ->where(function ($sale) {
                $sale->where('uniqid', 'like', '%' . $this->sale . '%');
            })
            ->latest()
            ->get();
    }

    public function selectSale()
    {
        $sale = $this->salelist[$this->salehighlightIndex] ?? null;
        if ($sale) {
            $higlightsale = $this->salelist[$this->salehighlightIndex];
            $this->selecthissale($higlightsale->id, $higlightsale->uniqid);
        }
    }

    public function selecthissale($id, $uniqid)
    {
        $this->issaleselected = true;
        $this->sale = $uniqid;
        $this->saleid = $id;
        $this->loadsalesitems();
    }

    public function loadsalesitems()
    {
        $selectedsalesitems = Saleitem::where('sale_id', $this->saleid)
            ->get();
        foreach ($selectedsalesitems as $index => $value) {
            $this->salereturitem[$index]['sale_id'] = $this->saleid;
            $this->salereturitem[$index]['saleitem_id'] = $value->id;
            $this->salereturitem[$index]['salereturn_id'] = null;
            $this->salereturitem[$index]['product_id'] = $value->product_id;
            $this->salereturitem[$index]['product_name'] = $value->product_name;
            $this->salereturitem[$index]['quantity'] = $value->quantity;
            $this->salereturitem[$index]['price'] = $value->price;
            $this->salereturitem[$index]['sellingprice'] = $value->sellingprice;
            $this->salereturitem[$index]['return_quantity'] = 0;
            $this->salereturitem[$index]['returned_quantity'] = $value->return_quantity;
            $this->salereturitem[$index]['returnable_quantity'] = $value->returnable_quantity;
            $this->salereturitem[$index]['return_amount'] = null;
            $this->salereturitem[$index]['is_selected'] = false;
        }
        $salereturncollection = collect($this->salereturitem);
    }

    public function updatedSalereturitem($value, $key)
    {
        $updated = explode(".", $key);
        if ($this->salereturitem[$updated[0]]['is_selected'] == true && $this->salereturitem[$updated[0]]['return_quantity'] !== '') {
        $validatekey = $updated[0];
            $this->withValidator(function (Validator $validator) use ($validatekey) {
                $validator->after(function ($validator) use ($validatekey) {
                    if ($this->salereturitem[$validatekey]['return_quantity'] == 0) {
                        $validator->errors()->add('return_quantity.' . $validatekey, 'Invalid');
                    }
                });
            })->validate();
            $this->submitbtn = true;
            $this->salereturitem[$updated[0]]['return_amount'] = $this->salereturitem[$updated[0]]['return_quantity'] * $this->salereturitem[$updated[0]]['price'];
            $salereturncollection = collect($this->salereturitem);
            $whole = floor($salereturncollection->sum('return_amount'));
            $fraction = $salereturncollection->sum('return_amount') - $whole;
            if ($fraction > 0.49) {
                $data['round_off'] = 1 - $fraction;
                $data['grand_total'] = $whole + 1;
            } else {
                $data['round_off'] = $fraction;
                $data['grand_total'] = $whole;
            }
            $this->debit_amount = $data;
        } elseif ($this->salereturitem[$updated[0]]['is_selected'] && $this->salereturitem[$updated[0]]['return_quantity'] == '') {
            $this->salereturitem[$updated[0]]['return_amount'] -= $this->salereturitem[$updated[0]]['return_amount'];
            $salereturncollection = collect($this->salereturitem);
            $whole = floor($salereturncollection->sum('return_amount'));
            $fraction = $salereturncollection->sum('return_amount') - $whole;
            if ($fraction > 0.49) {
                $data['round_off'] = 1 - $fraction;
                $data['grand_total'] = $whole + 1;
            } else {
                $data['round_off'] = $fraction;
                $data['grand_total'] = $whole;
            }
            $this->debit_amount = $data;
        } elseif (!$this->salereturitem[$updated[0]]['is_selected']) {
            $this->salereturitem[$updated[0]]['return_amount'] -= $this->salereturitem[$updated[0]]['return_amount'];
            $salereturncollection = collect($this->salereturitem);
            $whole = floor($salereturncollection->sum('return_amount'));
            $fraction = $salereturncollection->sum('return_amount') - $whole;
            if ($fraction > 0.49) {
                $data['round_off'] = 1 - $fraction;
                $data['grand_total'] = $whole + 1;
            } else {
                $data['round_off'] = $fraction;
                $data['grand_total'] = $whole;
            }
            $this->debit_amount = $data;
        }
    }

    public function store()
    {
        $salereturncollection = collect($this->salereturitem);
        if ($salereturncollection->where('is_selected', true)->count() > 0) {
            $validated = $this->validate();
            try {
                DB::beginTransaction();

                $salereturncollection = collect($this->salereturitem);
                $salereturn = Salereturn::create([
                    'sale_id' => $this->saleid,
                    'customer_id' => $this->customer_id,
                    'customer_name' => $this->customerselected?->name,
                    'customer_phone' => $this->customerselected?->phone,
                    'return_note' => $this->return_note,
                    'grandtotal' => $this->debit_amount['grand_total'],
                    'roundoff' => $this->debit_amount['round_off'],
                ]);

                $companysetting = Companysetting::first();
                $companysetting->balance = $companysetting->balance - $this->debit_amount['grand_total'];
                $companysetting->save();
                $salereturn->amountcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => $this->debit_amount['grand_total'],
                        'balance' => $companysetting->balance,
                        'c_or_d' => 'D',
                    ]);

                foreach ($this->salereturitem as $key => $value) {
                    if ($this->salereturitem[$key]['is_selected']) {
                        $salesreturnitem = Salereturnitem::create([
                            'product_id' => $this->salereturitem[$key]['product_id'],
                            'saleitem_id' => $this->salereturitem[$key]['saleitem_id'],
                            'salereturn_id' => $salereturn->id,
                            'return_quantity' => $this->salereturitem[$key]['return_quantity'],
                            'total' => $this->salereturitem[$key]['return_amount'],
                        ]);
                        $saleitem = Saleitem::find($this->salereturitem[$key]['saleitem_id']);
                        $saleitem->return_quantity += $this->salereturitem[$key]['return_quantity'];
                        $saleitem->returnable_quantity -= $this->salereturitem[$key]['return_quantity'];
                        $saleitem->save();
                        $product = Product::find($this->salereturitem[$key]['product_id']);
                        $product->stock = $product->stock + $this->salereturitem[$key]['return_quantity'];
                        $product->save();
                        $salereturn->stockcdable()
                            ->create([
                                'credit' => $this->salereturitem[$key]['return_quantity'],
                                'debit' => 0,
                                'balance' => $product->stock,
                                'c_or_d' => 'C',
                                'product_id' => $product->id,
                            ]);
                    }
                }
                DB::commit();
                $this->toaster('Success', 'Sales Return Created');
                return redirect()->route('adminsalereturn');
            } catch (Exception $e) {
                $this->exceptionerror($this->currentuser(), 'pharmacy_sales_return', 'error_one : ' . $e->getMessage());
            } catch (QueryException $e) {
                $this->exceptionerror($this->currentuser(), 'pharmacy_sales_return', 'error_two : ' . $e->getMessage());
            } catch (PDOException $e) {
                $this->exceptionerror($this->currentuser(), 'pharmacy_sales_return', 'error_three : ' . $e->getMessage());
            }
        } else {
            $this->submitbtn = false;
            $this->toaster('warning', 'Select a product');
        }

    }

    public function render()
    {
        return view('livewire.admin.salereturn.createsalereturnlivewire');
    }
}
