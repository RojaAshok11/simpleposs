<?php

namespace App\Livewire\Admin\Pos;

use App\Models\Admin\Customer\Customer;

trait Possalecustomerlivewire
{
    public $customer, $customerphone;
    public $searchcustomerlist = [];
    public $customerhighlightIndex = 0;

    public function updatedcustomerphone()
    {
        $this->searchcustomerlist = Customer::where('phone', 'like', '%' . $this->customerphone . '%')
            ->take(6)
            ->get();
    }

    public function entercustomer()
    {
        $customer = $this->searchcustomerlist[$this->customerhighlightIndex] ?? null;
        if ($customer) {
            $higlightcustomer = $this->searchcustomerlist[$this->customerhighlightIndex];
            $this->clickcustomer($higlightcustomer['id']);
        }
    }

    public function clickcustomer($customer_id)
    {

        $this->customer = Customer::find($customer_id);
        $this->form['customer_id'] = $this->customer->id;

        $this->customerphone = $this->customer->phone;
        $this->form['customer_phone'] = $this->customerphone;
        $this->form['customer_name'] = $this->customer->name;
        $this->form['customer_email'] = $this->customer->email;
        $this->searchcustomerlist = [];

    }

    public function customerincrement()
    {
        if ($this->customerhighlightIndex === count($this->searchcustomerlist) - 1) {
            $this->customerhighlightIndex = 0;
            return;
        }

        $this->customerhighlightIndex++;
    }

    public function customerdecrement()
    {

        if ($this->customerhighlightIndex === 0) {
            $this->customerhighlightIndex = count($this->searchcustomerlist) - 1;
            return;
        }

        $this->customerhighlightIndex--;
    }

}
