<?php

namespace App\Repository\Admin\Api\Businesslogic\Purchasereturn;

use App\Models\Admin\Product\Product;
use App\Models\Admin\Purchasereturn\Purchasereturn;
use App\Models\Admin\Purchasereturn\Purchasereturnitem;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Purchase\Purchaseitem;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Models\Admin\Supplier\Supplier;
use App\Repository\Admin\Api\Interfacelayer\Purchasereturn\IAdminpurchasereturnApiRepository;
use Illuminate\Support\Facades\Log;

class AdminpurchasereturnApiRepository implements IAdminpurchasereturnApiRepository
{
    public function admincreatepurchasereturn()
    {
        $purchasereturndetails = collect(json_decode((request()->purchasereturndetails)))->toArray();
        Log::info('Purchase Return details');
        Log::info(json_encode($purchasereturndetails));
        Log::info('----------------------------------------------------------------');
        Log::info('Supplier uuid');
        Log::info($purchasereturndetails['supplier_uuid']);
        $supplier = Supplier::where('uuid', $purchasereturndetails['supplier_uuid'])->first();
        $purchase = Purchase::where('uuid', $purchasereturndetails['purchase_uuid'])->first();
        Log::info('Supplier details');
        Log::info(json_encode($supplier));
        $purchasereturn = Purchasereturn::create([
            'purchase_id' => $purchase->id,
            'supplier_id' => $supplier->id,
            'supplier_name' => $supplier->name,
            'supplier_phone' => $supplier->phone,
            'total' => isset($purchasereturndetails['total']) && $purchasereturndetails['total'] != '' ? $purchasereturndetails['total'] : null,
            'round_off' => isset($purchasereturndetails['roundoff']) && $purchasereturndetails['roundoff'] != '' ? $purchasereturndetails['roundoff'] : null,
            'grand_total' => isset($purchasereturndetails['grandtotal']) && $purchasereturndetails['grandtotal'] != '' ? $purchasereturndetails['grandtotal'] : null,
            'issue_note' => isset($purchasereturndetails['return_note']) && $purchasereturndetails['return_note'] != '' ? $purchasereturndetails['return_note'] : null,
            'source_type' => isset($purchasereturndetails['source_type']) && $purchasereturndetails['source_type'] != '' ? $purchasereturndetails['source_type'] : null,
        ]);
        $companysetting = Companysetting::first();
        $companysetting->balance = $companysetting->balance + $purchasereturndetails['grandtotal'];
        $companysetting->save();
        $purchasereturn->amountcdable()
            ->create([
                'credit' => 0,
                'debit' => $purchasereturndetails['grandtotal'],
                'balance' => $companysetting->balance,
                'c_or_d' => 'C',
            ]);
        foreach ($purchasereturndetails['purchasereturnitem'] as $key => $value) {
            Log::info(json_encode($value));
            Log::info('----------------------------------------------------------------');
            $product = Product::where('uuid', $value->product_uuid)->first();
            $product->stock = $product->stock - $value->return_quantity;
            $product->save();
            $purchasereturn->stockcdable()
                ->create([
                    'credit' => $value->return_quantity,
                    'debit' => 0,
                    'balance' => $product->stock,
                    'c_or_d' => 'D',
                    'product_id' => $product->id,
                ]);
            $purchaseitem = Purchaseitem::where('uuid', $value->purchaseitem_uuid)->first();
            $purchaseitem->return_quantity += $value->return_quantity;
            $purchaseitem->returnable_quantity -= $value->return_quantity;
            $purchaseitem->save();
            $purchasereturnitem = Purchasereturnitem::create([
                'product_id' => $product->id,
                'purchaseitem_id' => $purchaseitem->id,
                'purchasereturn_id' => $purchasereturn->id,
                'return_quantity' => $value->return_quantity,
                'total' => $value->total,
            ]);
        }
        return [true, null, 'Purchase Return Created Successfully'];
    }
}
