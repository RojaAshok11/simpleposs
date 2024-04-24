<?php

namespace App\Repository\Admin\Api\Businesslogic\Order;

use App\Http\Resources\Admin\Order\OrderholdbyuuidResource;
use App\Http\Resources\Admin\Order\OrderholdCollection;
use App\Models\Admin\Customer\Customer;
use App\Models\Admin\Product\Product;
use App\Models\Admin\Salehold\Salehold;
use App\Models\Admin\Salehold\Saleholditem;
use App\Models\Admin\Sale\Sale;
use App\Models\Admin\Sale\Saleitem;
use App\Models\Admin\Settings\Generalsettings\Companysetting;
use App\Repository\Admin\Api\Interfacelayer\Order\IAdminplaceorderApiRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class AdminplaceorderApiRepository implements IAdminplaceorderApiRepository
{
    public function adminplaceorder()
    {
        $tax_type = App::make('possetting')->tax_type;
        $salesdetails = collect(json_decode((request()->salesdetails)))->toArray();
        Log::info('Sales details');
        Log::info(json_encode($salesdetails));
        $customer = Customer::where('uuid', $salesdetails['customer_uuid'])->first();
        if (!$customer && $salesdetails['customer_phone'] !='') {
            $customer = Customer::updateorCreate([
                'phone' => $salesdetails['customer_phone'],
            ], [
                'name' => $salesdetails['customer_name'],
            ]);
        }
        if (!$salesdetails['is_hold']) {
            $companysetting = Companysetting::first();

            if ($salesdetails['sales_uuid']) {
                $sale = Sale::where('uuid', $salesdetails['sales_uuid'])->first();
                if ($sale->grandtotal >= $salesdetails['grandtotal']) {
                    $sale->amountcdable()
                        ->create([
                            'credit' => 0,
                            'debit' => ($sale->grandtotal - $salesdetails['grandtotal']),
                            'balance' => $companysetting->balance - ($sale->grandtotal - $salesdetails['grandtotal']),
                            'c_or_d' => 'D',
                        ]);
                    $companysetting->balance = $companysetting->balance - ($sale->grandtotal - $salesdetails['grandtotal']);
                } else {
                    $sale->amountcdable()
                        ->create([
                            'credit' => ($salesdetails['grandtotal'] - $sale->grandtotal),
                            'debit' => 0,
                            'balance' => $companysetting->balance + ($salesdetails['grandtotal'] - $sale->grandtotal),
                            'c_or_d' => 'C',
                        ]);
                    $companysetting->balance = $companysetting->balance + ($salesdetails['grandtotal'] - $sale->grandtotal);
                }
                $companysetting->save();
            }

            $sale = Sale::updateorCreate([
                'uuid' => $salesdetails['sales_uuid'],
            ], [
                'customer_id' => $customer? $customer->id : null,
                'customer_name' => $customer? $customer->name : null,
                'customer_phone' => $customer? $customer->phone : null,
                'discount' => isset($salesdetails['discount']) && $salesdetails['discount'] != '' ? $salesdetails['discount'] : null,
                'extra_charges' => isset($salesdetails['extra_charges']) && $salesdetails['extra_charges'] != '' ? $salesdetails['extra_charges'] : null,
                'received_amount' => isset($salesdetails['received_amount']) && $salesdetails['received_amount'] != '' ? $salesdetails['received_amount'] : null,
                'remaining_amount' => isset($salesdetails['remaining_amount']) && $salesdetails['remaining_amount'] != '' ? $salesdetails['remaining_amount'] : null,
                'roundoff' => isset($salesdetails['roundoff']) && $salesdetails['roundoff'] != '' ? $salesdetails['roundoff'] : null,
                'grandtotal' => isset($salesdetails['grandtotal']) && $salesdetails['grandtotal'] != '' ? $salesdetails['grandtotal'] : null,
                'mode' => isset($salesdetails['mode']) && $salesdetails['mode'] != '' ? $salesdetails['mode'] : null,
                'source_type' => isset($salesdetails['source_type']) && $salesdetails['source_type'] != '' ? $salesdetails['source_type'] : null,
                'total_items' => sizeof($salesdetails['salesitem']),
            ]);
            if ($salesdetails['sales_uuid'] == null || $salesdetails['sales_uuid'] == '') {
                $sale->amountcdable()
                    ->create([
                        'credit' => $salesdetails['grandtotal'],
                        'debit' => 0,
                        'balance' => $companysetting->balance + $salesdetails['grandtotal'],
                        'c_or_d' => 'C',
                    ]);

                $companysetting->balance = $companysetting->balance + $salesdetails['grandtotal'];
                $companysetting->save();
            }
            foreach ($salesdetails['salesitem'] as $key => $value) {
                $product = Product::where('uuid', $value->product_uuid)->first();
                if ($value->saleitem_uuid) {
                    $saleitem = Saleitem::where('uuid', $value->saleitem_uuid)->first();
                    if ($saleitem->quantity != $value->quantity) {
                        if ($saleitem->quantity > $value->quantity) {
                            $productquantity = ($saleitem->quantity - $value->quantity);
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
                            $productquantity = ($value->quantity - $saleitem->quantity);
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
                    }
                } else {

                    $productquantity = $value->quantity;
                    $product->stock = $product->stock - $value->quantity;
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
                switch ($tax_type) {
                    case 1:
                        Saleitem::updateorCreate([
                            'uuid' => $value->saleitem_uuid,
                            'sale_id' => $sale->id,
                        ], [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'purchaseprice' => $product->purchaseprice,
                            'sellingprice' => $product->sellingprice,
                            'price' => $value->price,
                            'quantity' => $value->quantity,
                            'returnable_quantity' => $value->quantity,
                            'total' => $value->total,
                            'grandtotal' => $value->total,
                        ]);
                        break;
                    case 2:
                        $taxamt = $value->total - ($value->total * (100 / (100 + ($product->cgst + $product->sgst) ) ) );
                        $taxable = $value->total - $taxamt;
                        Saleitem::updateorCreate([
                            'uuid' => $value->saleitem_uuid,
                            'sale_id' => $sale->id,
                        ], [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'purchaseprice' => $product->purchaseprice,
                            'sellingprice' => $product->sellingprice,
                            'price' => $taxable,
                            'quantity' => $value->quantity,
                            'returnable_quantity' => $value->quantity,
                            'taxamt' => $taxamt,
                            'taxable' => $taxable,
                            'cgst' => $product->cgst ? $product->cgst : null,
                            'cgstamt' => number_format((float) ($taxamt), 2, '.', ''),
                            'sgst' => $product->sgst ? $product->sgst : null,
                            'sgstamt' => number_format((float) ($taxamt), 2, '.', ''),
                            'total' => $value->total,
                            'grandtotal' => $value->total,
                        ]);
                        break;
                    case 3:
                        $taxamt = $value->total - ($value->total * (100 / (100 + $product->vat ) ) );
                        $taxable = $value->total - $taxamt;
                        Saleitem::updateorCreate([
                            'uuid' => $value->saleitem_uuid,
                            'sale_id' => $sale->id,
                        ], [
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'purchaseprice' => $product->purchaseprice,
                            'sellingprice' => $product->sellingprice,
                            'price' => $taxable,
                            'quantity' => $value->quantity,
                            'returnable_quantity' => $value->quantity,
                            'taxamt' => $taxamt,
                            'taxable' => $taxable,
                            'vat' => $product->vat ? $product->vat : null,
                            'vatamt' => $value->total * ($product->vat / 100),
                            'total' => $value->total,
                            'grandtotal' => $value->total,
                        ]);
                }
            }
            switch ($tax_type) {
                case 1:
                    $sale->update([
                        'sub_total' => isset($salesdetails['sub_total']) && $salesdetails['sub_total'] != '' ? $salesdetails['sub_total'] : null,
                        'total' => isset($salesdetails['total']) && $salesdetails['total'] != '' ? $salesdetails['total'] : null,
                    ]);
                    break;
                case 2:
                    $sale->update([
                        'sub_total' => $sale->saleitem->sum('taxable'),
                        'total' => $sale->saleitem->sum('taxable') + $sale->extra_charges - $sale->discount,
                        'taxamt' => $sale->saleitem->sum('taxamt'),
                        'taxableamt' => $sale->saleitem->sum('taxable'),
                        'cgst' => $sale->saleitem->sum('cgstamt'),
                        'sgst' => $sale->saleitem->sum('sgstamt'),
                    ]);
                    break;
                case 3:
                    $sale->update([
                        'sub_total' => $sale->saleitem->sum('taxable'),
                        'total' => $sale->saleitem->sum('taxable') + $sale->extra_charges - $sale->discount,
                        'taxamt' => $sale->saleitem->sum('taxamt'),
                        'taxableamt' => $sale->saleitem->sum('taxable'),
                        'vat' => $sale->saleitem->sum('vatamt'),
                    ]);
                    break;
            }
            if (isset($salesdetails['saleshold_uuid']) && $salesdetails['saleshold_uuid'] != '') {
                $salehold = Salehold::where('uuid', $salesdetails['saleshold_uuid'])->first();
                Saleholditem::where('salehold_id', $salehold->id)->delete();
                $salehold->delete();
            }
            return [true, null, 'Order placed successfully'];
        } else {
            $salehold = Salehold::updateorCreate([
                'uuid' => $salesdetails['saleshold_uuid'],
                'reference_id' => $salesdetails['reference_id'],
            ], [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'source_type' => isset($salesdetails['source_type']) && $salesdetails['source_type'] != '' ? $salesdetails['source_type'] : null,
            ]);
            foreach ($salesdetails['salesitem'] as $key => $value) {
                Log::info(json_encode($value));
                $product = Product::where('uuid', $value->product_uuid)->first();
                Saleholditem::updateorCreate([
                    'uuid' => $value->saleholditem_uuid,
                    'salehold_id' => $salehold->id,
                ], [
                    'product_id' => $product->id,
                    'quantity' => $value->quantity,
                ]);
            }
            return [true, null, 'Yoy'];
        }
    }

    public function adminholdorderlist()
    {
        return [true,
            new OrderholdCollection(Salehold::where('user_id', auth()->user()->id)
                    ->where(fn($q) =>
                        $q->where('uniqid', 'like', '%' . request('search') . '%')
                            ->orWhere('reference_id', 'like', '%' . request('search') . '%')
                            ->orWhere('customer_name', 'like', '%' . request('search') . '%')
                            ->orWhere('customer_phone', 'like', '%' . request('search') . '%')
                    )
                    ->latest()
                    ->paginate(10)),
            'adminholdorderlist'];
    }

    public function admingetholdorder()
    {
        return [true,
            OrderholdbyuuidResource::collection(Salehold::where('uuid', request('uuid'))->get()),
            'admingetholdorder'];
    }

    public function admindeleteholdorder()
    {
        $salehold = Salehold::where('uuid', request('uuid'))->first();
        Saleholditem::where('salehold_id', $salehold->id)->delete();
        $salehold->delete();
        return [true, null, 'admindeleteholdorder'];
    }

    public function admindeleteholdorderitem()
    {
        Saleholditem::where('uuid', request('uuid'))->delete();

        return [true, null, 'admindeleteholdorderitem'];
    }

    public function admindeleteorderitem()
    {
        Saleitem::where('uuid', request('uuid'))->delete();

        return [true, null, 'admindeleteorderitem'];
    }
}
