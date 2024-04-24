<?php

namespace App\Livewire\Admin\Purchase;

use App\Models\Admin\Supplier\Supplier;

trait Purchasesupplierlivewire
{
    public $suppliername, $phone, $email, $address, $gstin, $pan;
    public $searchsupplierlist = [];
    public $supplierhighlightIndex = 0;

    public function updatedSuppliername()
    {
        $this->searchsupplierlist = Supplier::where('active', true)
            ->where('name', 'like', '%' . $this->suppliername . '%')
            ->take(6)
            ->get();
    }

    public function entersupplier()
    {
        $supplier = $this->searchsupplierlist[$this->supplierhighlightIndex] ?? null;
        if ($supplier) {
            $higlightsupplier = $this->searchsupplierlist[$this->supplierhighlightIndex];
            $this->clicksupplier($higlightsupplier['id']);
        }
    }

    public function clicksupplier($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);
        $this->form['supplier_id'] = $supplier->id;

        $this->suppliername = $supplier->name;
        $this->form['supplier_name'] = $this->suppliername;
        $this->form['supplier_phone'] = $supplier->phone;
        $this->form['supplier_email'] = $supplier->email;
        $this->form['supplier_address'] = $supplier->address;
        $this->form['gst'] = $supplier->gst;
        $this->form['pan'] = $supplier->pan;
        $this->searchsupplierlist = [];

    }

    public function supplierincrement()
    {
        if ($this->supplierhighlightIndex === count($this->searchsupplierlist) - 1) {
            $this->supplierhighlightIndex = 0;
            return;
        }

        $this->supplierhighlightIndex++;
    }

    public function supplierdecrement()
    {

        if ($this->supplierhighlightIndex === 0) {
            $this->supplierhighlightIndex = count($this->searchsupplierlist) - 1;
            return;
        }

        $this->supplierhighlightIndex--;
    }

}
