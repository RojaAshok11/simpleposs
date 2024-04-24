<?php

namespace App\Repository\Admin\Api\Businesslogic\Salesreturn;

use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Sale\Saleitem;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Salereturn\Salereturn;
use App\Models\Admin\Salereturn\Salereturnitem;
use App\Http\Resources\Admin\Salereturn\ShowsalereturnResource;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Http\Resources\Admin\Salereturn\SalereturnlistCollection;
use App\Repository\Admin\Api\Interfacelayer\Salesreturn\IAdminsalesreturnApiRepository;

class AdminsalesreturnApiRepository implements IAdminsalesreturnApiRepository
{
    public function admincreatesalereturn()
    {
        $salesreturndetails = collect(json_decode((request()->salesreturndetails)))->toArray();
        Log::info('Sales Return details');
        Log::info(json_encode($salesreturndetails));
        Log::info('----------------------------------------------------------------');
        Log::info('Customer uuid');
        Log::info($salesreturndetails['customer_uuid']);
        $customer = Customer::where('uuid', $salesreturndetails['customer_uuid'])->first();
        $sale = Sale::where('uuid', $salesreturndetails['sales_uuid'])->first();
        Log::info('Customer details');
        Log::info(json_encode($customer));
        $salereturn = Salereturn::create([
            'sale_id' => $sale->id,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            'total' => isset($salesreturndetails['total']) && $salesreturndetails['total'] != '' ? $salesreturndetails['total'] : null,
            'roundoff' => isset($salesreturndetails['roundoff']) && $salesreturndetails['roundoff'] != '' ? $salesreturndetails['roundoff'] : null,
            'grandtotal' => isset($salesreturndetails['grandtotal']) && $salesreturndetails['grandtotal'] != '' ? $salesreturndetails['grandtotal'] : null,
            'return_note' => isset($salesreturndetails['return_note']) && $salesreturndetails['return_note'] != '' ? $salesreturndetails['return_note'] : null,
            'source_type' => isset($salesreturndetails['source_type']) && $salesreturndetails['source_type'] != '' ? $salesreturndetails['source_type'] : null,
        ]);
        $companysetting = Companysetting::first();
        $companysetting->balance = $companysetting->balance - $salesreturndetails['grandtotal'];
        $companysetting->save();
        $salereturn->amountcdable()
            ->create([
                'credit' => 0,
                'debit' => $salesreturndetails['grandtotal'],
                'balance' => $companysetting->balance,
                'c_or_d' => 'D',
            ]);
        foreach ($salesreturndetails['salesreturnitem'] as $key => $value) {
            Log::info(json_encode($value));
            Log::info('----------------------------------------------------------------');
            $product = Product::where('uuid', $value->product_uuid)->first();
            $product->stock = $product->stock + $value->return_quantity;
            $product->save();
            $salereturn->stockcdable()
                ->create([
                    'credit' => $value->return_quantity,
                    'debit' => 0,
                    'balance' => $product->stock,
                    'c_or_d' => 'C',
                    'product_id' => $product->id,
                ]);
            $saleitem = Saleitem::where('uuid', $value->saleitem_uuid)->first();
            $saleitem->return_quantity += $value->return_quantity;
            $saleitem->returnable_quantity -= $value->return_quantity;
            $saleitem->save();

            $salesreturnitem = Salereturnitem::create([
                'product_id' => $product->id,
                'saleitem_id' => $saleitem->id,
                'salereturn_id' => $salereturn->id,
                'return_quantity' => $value->return_quantity,
                'total' => $value->total,
            ]);
        }
        return [true, null, 'Sale Return Created Successfully'];
    }

    public function admingetsalereturnlist()
    {
        return [true,
            new SalereturnlistCollection(Salereturn::where(fn($q) =>
                $q->where('uniqid', 'like', '%' . request('search') . '%')
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'like', '%' . request('search') . '%'))
                    ->orWhereHas('customer', fn($q) => $q->where('phone', 'like', '%' . request('search') . '%'))
            )
                    ->latest()
                    ->paginate(10)),
            'admingetsalereturnlist'];
    }

    public function admingetsalereturnbyuuid()
    {
        return [true,
            ShowsalereturnResource::collection(Salereturn::where('uuid', request('uuid'))->get()),
            'admingetsalereturnbyuuid'];
    }
}
