<?php

namespace App\Livewire\Admin\Pos;

use App\Models\Admin\Product\Product;
use App\Models\Admin\Sale\Saleitem;
use App\Models\Admin\Settings\Generalsettings\Companysetting;

trait Possalecreditordebitlivewire
{
    protected function stockcreditanddebit($sale, $productdata): void
    {

        $product = Product::find($productdata['product_id']);

        if ($productdata['product_saleitemid']) {

            $saleitem = Saleitem::find($productdata['product_saleitemid']);

            if ($saleitem->quantity >= $productdata['product_quantity']) {

                $productquantity = ($saleitem->quantity - $productdata['product_quantity']);

                $product->stock = $product->stock + $productquantity;
                $sale->stockcdable()
                    ->create([
                        'credit' => $productquantity,
                        'debit' => 0,
                        'balance' => $product->stock,
                        'c_or_d' => 'C',
                        'product_id' => $product->id,
                    ]);
            } else {
                $productquantity = ($productdata['product_quantity'] - $saleitem->quantity);
                $product->stock = $product->stock - $productquantity;
                $sale->stockcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => $productquantity,
                        'balance' => $product->stock,
                        'c_or_d' => 'D',
                        'product_id' => $product->id,
                    ]);
            }

        } else {

            $productquantity = $productdata['product_quantity'];
            $product->stock = $product->stock - $productdata['product_quantity'];
            $sale->stockcdable()
                ->create([
                    'credit' => 0,
                    'debit' => $productquantity,
                    'balance' => $product->stock,
                    'c_or_d' => 'D',
                    'product_id' => $product->id,
                ]);
        }

        $product->save();

    }

    protected function amountcreditanddebit($sale, $type): void
    {

        $companysetting = Companysetting::first();

        if ($type == 'CREATE') {
            $sale->amountcdable()
                ->create([
                    'credit' => $this->form['grandtotal'],
                    'debit' => 0,
                    'balance' => $companysetting->balance + $this->form['grandtotal'],
                    'c_or_d' => 'C',
                ]);

            $companysetting->balance = $companysetting->balance + $this->form['grandtotal'];
            $companysetting->save();

        } else { // UPDATE

            if ($sale->grandtotal >= $this->form['grandtotal']) {
                $sale->amountcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => ($sale->grandtotal - $this->form['grandtotal']),
                        'balance' => $companysetting->balance - ($sale->grandtotal - $this->form['grandtotal']),
                        'c_or_d' => 'D',
                    ]);
                $companysetting->balance = $companysetting->balance - ($sale->grandtotal - $this->form['grandtotal']);
            } else {
                $sale->amountcdable()
                    ->create([
                        'credit' => ($this->form['grandtotal'] - $sale->grandtotal),
                        'debit' => 0,
                        'balance' => $companysetting->balance + ($this->form['grandtotal'] - $sale->grandtotal),
                        'c_or_d' => 'C',
                    ]);
                $companysetting->balance = $companysetting->balance + ($this->form['grandtotal'] - $sale->grandtotal);
            }
            $companysetting->save();
        }

    }
}
