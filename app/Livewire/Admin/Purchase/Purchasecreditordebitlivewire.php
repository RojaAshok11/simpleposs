<?php

namespace App\Livewire\Admin\Purchase;

use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Models\Admin\Settings\Generalsettings\Companysetting;

trait Purchasecreditordebitlivewire
{
    protected function stockcreditanddebit($purchase, $productdata): void
    {

        $product = Product::find($productdata['product_id']);
        if ($productdata['product_purchaseitemid']) {
            $purchaseitem = Purchaseitem::find($productdata['product_purchaseitemid']);
            if ($purchaseitem->quantity != $productdata['product_quantity']) {

                if ($productdata['product_quantity'] < $purchaseitem->quantity) {
                    $productquantity = ($purchaseitem->quantity - $productdata['product_quantity']);
                    $updatedquantity = $product->stock - $productquantity;
                    $c_or_d = 'D';
                } elseif ($productdata['product_quantity'] > $purchaseitem->quantity) {
                    $productquantity = ($productdata['product_quantity'] - $purchaseitem->quantity);
                    $updatedquantity = $product->stock + $productquantity;
                    $c_or_d = 'C';
                }

                $product->stock = $updatedquantity;
                $purchase->stockcdable()
                    ->create([
                        'credit' => $c_or_d == 'C' ? $productquantity : 0,
                        'debit' => $c_or_d == 'D' ? $productquantity : 0,
                        'balance' => $product->stock,
                        'c_or_d' => $c_or_d,
                        'product_id' => $product->id,
                    ]);

            } else {
                $productquantity = ($productdata['product_quantity'] - $purchaseitem->quantity);
                $product->stock = $product->stock + $productquantity;
                $purchase->stockcdable()
                    ->create([
                        'credit' => $productquantity,
                        'debit' => 0,
                        'balance' => $product->stock,
                        'c_or_d' => 'C',
                        'product_id' => $product->id,
                    ]);
            }

        } else {
            $productquantity = $productdata['product_quantity'];
            $product->stock = $product->stock + $productdata['product_quantity'];
            $purchase->stockcdable()
                ->create([
                    'credit' => $productquantity,
                    'debit' => 0,
                    'balance' => $product->stock,
                    'c_or_d' => 'C',
                    'product_id' => $product->id,
                ]);

        }
        $product->save();
    }

    protected function amountcreditanddebit($purchase, $type): void
    {

        $companysetting = Companysetting::first();

        if ($type == 'CREATE') {
            $purchase->amountcdable()
                ->create([
                    'credit' => 0,
                    'debit' => $this->form['grandtotal'],
                    'balance' => $companysetting->balance - $this->form['grandtotal'],
                    'c_or_d' => 'D',
                ]);

            $companysetting->balance = $companysetting->balance - $this->form['grandtotal'];
            $companysetting->save();

        } else { // UPDATE
            if ($purchase->grandtotal >= $this->form['grandtotal']) {
                $purchase->amountcdable()
                    ->create([
                        'credit' => ($purchase->grandtotal - $this->form['grandtotal']),
                        'debit' => 0,
                        'balance' => $companysetting->balance + ($purchase->grandtotal - $this->form['grandtotal']),
                        'c_or_d' => 'C',
                    ]);
                $companysetting->balance = $companysetting->balance + ($purchase->grandtotal - $this->form['grandtotal']);
            } else {
                $purchase->amountcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => ($this->form['grandtotal'] - $purchase->grandtotal),
                        'balance' => $companysetting->balance + ($purchase->grandtotal - $this->form['grandtotal']),
                        'c_or_d' => 'D',
                    ]);
                $companysetting->balance = $companysetting->balance + ($purchase->grandtotal - $this->form['grandtotal']);
            }
            $companysetting->save();
        }
    }
}
