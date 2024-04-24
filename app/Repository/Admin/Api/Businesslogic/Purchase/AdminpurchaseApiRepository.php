<?php

namespace App\Repository\Admin\Api\Businesslogic\Purchase;

use App\Http\Resources\Admin\Purchase\PurchaseCollection;
use App\Http\Resources\Admin\Purchase\PurchaseshowResource;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Models\Admin\Supplier\Supplier;
use App\Repository\Admin\Api\Interfacelayer\Purchase\IAdminpurchaseApiRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminpurchaseApiRepository implements IAdminpurchaseApiRepository
{
    public function admincreateoreditpurchase()
    {
        $purchasedetails = collect(json_decode((request()->purchasedetails)))->toArray();
        Log::info('Purchases details');
        Log::info(json_encode($purchasedetails));
        Log::info('----------------------------------------------------------------');
        Log::info('Supplier uuid');
        Log::info($purchasedetails['supplier_uuid']);
        $supplier = Supplier::where('uuid', $purchasedetails['supplier_uuid'])->first();
        Log::info('Supplier details');
        Log::info(json_encode($supplier));
        $companysetting = Companysetting::first();
        if ($purchasedetails['purchase_uuid']) {
            $purchase = Purchase::where('uuid', $purchasedetails['purchase_uuid'])->first();
            if ($purchase->grandtotal >= $purchasedetails['grandtotal']) {
                $purchase->amountcdable()
                    ->create([
                        'credit' => ($purchase->grandtotal - $purchasedetails['grandtotal']),
                        'debit' => 0,
                        'balance' => $companysetting->balance + ($purchase->grandtotal - $purchasedetails['grandtotal']),
                        'c_or_d' => 'C',
                    ]);
                $companysetting->balance = $companysetting->balance + ($purchase->grandtotal - $purchasedetails['grandtotal']);
            } else {
                $purchase->amountcdable()
                    ->create([
                        'credit' => 0,
                        'debit' => ($purchasedetails['grandtotal'] - $purchase->grandtotal),
                        'balance' => $companysetting->balance + ($purchase->grandtotal - $purchasedetails['grandtotal']),
                        'c_or_d' => 'D',
                    ]);
                $companysetting->balance = $companysetting->balance + ($purchase->grandtotal - $purchasedetails['grandtotal']);
            }
            $companysetting->save();
        }
        $purchase = Purchase::updateorCreate([
            'uuid' => $purchasedetails['purchase_uuid'],
        ], [
            'supplier_id' => $supplier->id,
            'supplier_name' => $supplier->name,
            'supplier_phone' => $supplier->phone,
            'supplier_email' => $supplier->email,
            'supplier_address' => $supplier->address,
            'purchase_date' => isset($purchasedetails['purchase_date']) && $purchasedetails['purchase_date'] != '' ? Carbon::parse($purchasedetails['purchase_date'])->format('Y-m-d') : null,
            'gst' => $supplier->gst,
            'pan' => $supplier->pan,
            'sub_total' => isset($purchasedetails['sub_total']) && $purchasedetails['sub_total'] != '' ? $purchasedetails['sub_total'] : null,
            'discount' => isset($purchasedetails['discount']) && $purchasedetails['discount'] != '' ? $purchasedetails['discount'] : null,
            'freight_charges' => isset($purchasedetails['freight_charges']) && $purchasedetails['freight_charges'] != '' ? $purchasedetails['freight_charges'] : null,
            'adjustment' => isset($purchasedetails['adjustment']) && $purchasedetails['adjustment'] != '' ? $purchasedetails['adjustment'] : null,
            'total_items' => sizeof($purchasedetails['purchaseitem']),
            'total' => isset($purchasedetails['total']) && $purchasedetails['total'] != '' ? $purchasedetails['total'] : null,
            'roundoff' => isset($purchasedetails['roundoff']) && $purchasedetails['roundoff'] != '' ? $purchasedetails['roundoff'] : null,
            'grandtotal' => isset($purchasedetails['grandtotal']) && $purchasedetails['grandtotal'] != '' ? $purchasedetails['grandtotal'] : null,
            'note' => isset($purchasedetails['note']) && $purchasedetails['note'] != '' ? $purchasedetails['note'] : null,
            'source_type' => isset($purchasedetails['source_type']) && $purchasedetails['source_type'] != '' ? $purchasedetails['source_type'] : null,
        ]);

        if ($purchasedetails['purchase_uuid'] == null || $purchasedetails['purchase_uuid'] == '') {
            $purchase->amountcdable()
                ->create([
                    'credit' => 0,
                    'debit' => $purchasedetails['grandtotal'],
                    'balance' => $companysetting->balance - $purchasedetails['grandtotal'],
                    'c_or_d' => 'D',
                ]);

            $companysetting->balance = $companysetting->balance - $purchasedetails['grandtotal'];
            $companysetting->save();

        }
        Log::info('Purchase');
        Log::info(json_encode($purchase));
        Log::info('----------------------------------------------------------------');
        foreach ($purchasedetails['purchaseitem'] as $key => $value) {
            Log::info(json_encode($value));
            Log::info('----------------------------------------------------------------');
            $product = Product::where('uuid', $value->product_uuid)->first();
            if ($value->purchaseitem_uuid) {
                $purchaseitem = Purchaseitem::where('uuid', $value->purchaseitem_uuid)->first();
                if ($purchaseitem->quantity != $value->quantity) {

                    if ($value->quantity < $purchaseitem->quantity) {
                        $productquantity = ($purchaseitem->quantity - $value->quantity);
                        $updatedquantity = $product->stock - $productquantity;
                        $c_or_d = 'D';
                    } elseif ($value->quantity > $purchaseitem->quantity) {
                        $productquantity = ($value->quantity - $purchaseitem->quantity);
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
                    $productquantity = ($value->quantity - $purchaseitem->quantity);
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
                $productquantity = $value->quantity;
                $product->stock = $product->stock + $value->quantity;
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

            $purchaseitem = Purchaseitem::updateorCreate([
                'uuid' => $value->purchaseitem_uuid,
                'purchase_id' => $purchase->id,
            ], [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'purchaseprice' => $product->purchaseprice,
                'sellingprice' => $product->sellingprice,
                'price' => $value->price,
                'quantity' => $value->quantity,
                'returnable_quantity' => $value->quantity,
                'total' => $value->total,
            ]);

        }
        return [true, null, 'Purchase Created Successfully'];
    }

    public function adminpurchaselist()
    {
        return [true,

            new PurchaseCollection(Purchase::query()
                    ->where(function ($query) {
                        $query->where('uniqid', 'like', '%' . request()->search . '%')
                            ->orWhere('supplier_name', 'like', '%' . request()->search . '%');
                    })
                    ->active()
                    ->latest()
                    ->paginate(10)),
            'Purchase List'];
    }

    public function adminshowpurchase()
    {
        return [true, PurchaseshowResource::collection(Purchase::where('uuid', request()->uuid)->get()), 'Show Purchase'];
    }
}
