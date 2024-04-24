<?php

namespace App\Livewire\Admin\Purchasereturn;

use App\Livewire\Admin\Purchase\Purchasesupplierlivewire;
use App\Livewire\Livewirehelper\Miscellaneous\miscellaneousLivewireTrait;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchasereturn\Purchasereturn;
use App\Models\Admin\Purchasereturn\Purchasereturnitem;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Createpurchasereturnlivewire extends Component
{
    use miscellaneousLivewireTrait, Purchasesupplierlivewire;

    public $form = [
        'supplier_id' => '',
        'supplier_name' => '',
        'supplier_phone' => '',
        'supplier_email' => '',
        'supplier_address' => '',
        'gst' => '',
        'pan' => '',
    ];
    public $purchase, $purchaseid, $return_note;
    public $purchaselist = [];
    public $purchasehighlightIndex = 0;
    public $ispurchaseselected = false;
    public $purchasereturitem = [];
    public $debit_amount = [];
    public $submitbtn = true;
    public $supplierhighlightIndex = 0;

    protected function rules(): array
    {
        return [

            'form.supplier_id' => 'required|integer',

            'form.supplier_name' => 'required|string|min:2|max:70',
            'form.supplier_phone' => 'required|digits:10',
            'return_note' => 'required|min:3|max:255',

            'purchasereturitem' => 'required|array',
            'purchasereturitem.*.return_quantity' => 'required_if:purchasereturitem.*.is_selected,==,true|nullable|lte:purchasereturitem.*.returnable_quantity|lte:purchasereturitem.*.quantity|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'purchasereturitem.*.return_quantity.required_if' => 'Enter Quantity',
            'purchasereturitem.*.return_quantity.lte' => 'Return Quantity Exceeds',
            'purchasereturitem.*.quantity.lte' => 'Return Quantity Exceeds',
            'purchasereturitem.*.return_quantity.gt' => 'Invalid Quantity',
        ];
    }

    public function purchaseincrementHighlight()
    {
        if ($this->purchasehighlightIndex === count($this->purchaselist) - 1) {
            $this->purchasehighlightIndex = 0;
            return;
        }
        $this->purchasehighlightIndex++;
    }

    public function purchasedecrementHighlight()
    {
        if ($this->purchasehighlightIndex === 0) {
            $this->purchasehighlightIndex = count($this->purchaselist) - 1;
            return;
        }
        $this->purchasehighlightIndex--;
    }

    public function updatedPurchase()
    {
        $this->ispurchaseselected = false;
        $this->purchaselist = Purchase::where('supplier_id', $this->form['supplier_id'])
            ->where(function ($purchase) {
                $purchase->where('uniqid', 'like', '%' . $this->purchase . '%');
            })
            ->latest()
            ->get();
    }

    public function selectPurchase()
    {
        $purchase = $this->purchaselist[$this->purchasehighlightIndex] ?? null;
        if ($purchase) {
            $higlightpurchase = $this->purchaselist[$this->purchasehighlightIndex];
            $this->selecthispurchase($higlightpurchase->id, $higlightpurchase->uniqid);
        }
    }

    public function loadpurchasesitems()
    {
        $selectedpurchaseitems = Purchaseitem::where('purchase_id', $this->purchaseid)
            ->get();
        foreach ($selectedpurchaseitems as $index => $value) {
            $this->purchasereturitem[$index]['purchase_id'] = $this->purchaseid;
            $this->purchasereturitem[$index]['purchaseitem_id'] = $value->id;
            $this->purchasereturitem[$index]['purchasereturn_id'] = null;
            $this->purchasereturitem[$index]['product_id'] = $value->product_id;
            $this->purchasereturitem[$index]['product_name'] = $value->product_name;
            $this->purchasereturitem[$index]['quantity'] = $value->quantity;
            $this->purchasereturitem[$index]['price'] = $value->price;
            $this->purchasereturitem[$index]['purchaseprice'] = $value->purchaseprice;
            $this->purchasereturitem[$index]['return_quantity'] = 0;
            $this->purchasereturitem[$index]['returned_quantity'] = $value->return_quantity;
            $this->purchasereturitem[$index]['returnable_quantity'] = $value->returnable_quantity;
            $this->purchasereturitem[$index]['return_amount'] = null;
            $this->purchasereturitem[$index]['is_selected'] = false;
        }
        $purchasereturncollection = collect($this->purchasereturitem);
    }

    public function selecthispurchase($id, $uniqid)
    {
        $this->ispurchaseselected = true;
        $this->purchase = $uniqid;
        $this->purchaseid = $id;
        $this->loadpurchasesitems();
    }

    public function updatedPurchasereturitem($value, $key)
    {
        $updated = explode(".", $key);
        if ($this->purchasereturitem[$updated[0]]['is_selected'] == true && $this->purchasereturitem[$updated[0]]['return_quantity'] !== '') {
            $this->submitbtn = true;
            $this->purchasereturitem[$updated[0]]['return_amount'] = $this->purchasereturitem[$updated[0]]['return_quantity'] * $this->purchasereturitem[$updated[0]]['price'];
            $purchasereturncollection = collect($this->purchasereturitem);
            $whole = floor($purchasereturncollection->sum('return_amount'));
            $fraction = $purchasereturncollection->sum('return_amount') - $whole;
            if ($fraction > 0.49) {
                $data['round_off'] = 1 - $fraction;
                $data['grand_total'] = $whole + 1;
            } else {
                $data['round_off'] = $fraction;
                $data['grand_total'] = $whole;
            }
            $this->debit_amount = $data;
        } elseif ($this->purchasereturitem[$updated[0]]['is_selected'] && $this->purchasereturitem[$updated[0]]['return_quantity'] == '') {
            $this->purchasereturitem[$updated[0]]['return_amount'] -= $this->purchasereturitem[$updated[0]]['return_amount'];
            $purchasereturncollection = collect($this->purchasereturitem);
            $whole = floor($purchasereturncollection->sum('return_amount'));
            $fraction = $purchasereturncollection->sum('return_amount') - $whole;
            if ($fraction > 0.49) {
                $data['round_off'] = 1 - $fraction;
                $data['grand_total'] = $whole + 1;
            } else {
                $data['round_off'] = $fraction;
                $data['grand_total'] = $whole;
            }
            $this->debit_amount = $data;
        } elseif (!$this->purchasereturitem[$updated[0]]['is_selected']) {
            $this->purchasereturitem[$updated[0]]['return_amount'] -= $this->purchasereturitem[$updated[0]]['return_amount'];
            $purchasereturncollection = collect($this->purchasereturitem);
            $whole = floor($purchasereturncollection->sum('return_amount'));
            $fraction = $purchasereturncollection->sum('return_amount') - $whole;
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
        $purchasereturncollection = collect($this->purchasereturitem);
        if ($purchasereturncollection->where('is_selected', true)->count() > 0) {
            $validated = $this->validate();
            try {
                DB::beginTransaction();

                $purchasereturn = Purchasereturn::create([
                    'purchase_id' => $this->purchaseid,
                    'supplier_id' => $this->form['supplier_id'],
                    'supplier_name' => $this->form['supplier_name'],
                    'supplier_phone' => $this->form['supplier_phone'],
                    'issue_note' => $this->return_note,
                    'grand_total' => $this->debit_amount['grand_total'],
                    'round_off' => $this->debit_amount['round_off'],
                ]);

                $companysetting = Companysetting::first();
                $companysetting->balance = $companysetting->balance + $this->debit_amount['grand_total'];
                $companysetting->save();
                $purchasereturn->amountcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => $this->debit_amount['grand_total'],
                        'balance' => $companysetting->balance,
                        'c_or_d' => 'C',
                    ]);

                foreach ($this->purchasereturitem as $key => $value) {
                    if ($this->purchasereturitem[$key]['is_selected']) {
                        $purchasesreturnitem = Purchasereturnitem::create([
                            'product_id' => $this->purchasereturitem[$key]['product_id'],
                            'purchaseitem_id' => $this->purchasereturitem[$key]['purchaseitem_id'],
                            'purchasereturn_id' => $purchasereturn->id,
                            'return_quantity' => $this->purchasereturitem[$key]['return_quantity'],
                            'total' => $this->purchasereturitem[$key]['return_amount'],
                        ]);
                        $purchaseitem = Purchaseitem::find($this->purchasereturitem[$key]['purchaseitem_id']);
                        $purchaseitem->return_quantity += $this->purchasereturitem[$key]['return_quantity'];
                        $purchaseitem->returnable_quantity -= $this->purchasereturitem[$key]['return_quantity'];
                        $purchaseitem->save();
                        $product = Product::find($this->purchasereturitem[$key]['product_id']);
                        $product->stock = $product->stock - $this->purchasereturitem[$key]['return_quantity'];
                        $product->save();
                        $purchasereturn->stockcdable()
                            ->create([
                                'credit' => $this->purchasereturitem[$key]['return_quantity'],
                                'debit' => 0,
                                'balance' => $product->stock,
                                'c_or_d' => 'D',
                                'product_id' => $product->id,
                            ]);
                    }

                }
                DB::commit();
                $this->toaster('Success', 'Purchases Return Created');
                return redirect()->route('adminpurchasereturn');
            } catch (Exception $e) {
                $this->exceptionerror($this->currentuser(), 'pharmacy_purchases_return', 'error_one : ' . $e->getMessage());
            } catch (QueryException $e) {
                $this->exceptionerror($this->currentuser(), 'pharmacy_purchases_return', 'error_two : ' . $e->getMessage());
            } catch (PDOException $e) {
                $this->exceptionerror($this->currentuser(), 'pharmacy_purchases_return', 'error_three : ' . $e->getMessage());
            }
        } else {
            $this->submitbtn = false;
            $this->toaster('warning', 'Select a product');
        }

    }

    public function render()
    {
        return view('livewire.admin.purchasereturn.createpurchasereturnlivewire');
    }
}
