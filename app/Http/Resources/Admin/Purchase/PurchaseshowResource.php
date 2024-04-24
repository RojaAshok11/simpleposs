<?php

namespace App\Http\Resources\Admin\Purchase;

use App\Http\Resources\Admin\Purchase\PurchaseitemResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseshowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid ? $this->uuid : '',
            'uniqid' => $this->uniqid ? $this->uniqid : '',
            'supplier_uuid' => $this->supplier_id ? $this->supplier->uuid : '',
            'supplier_name' => $this->supplier_name ? $this->supplier_name : '',
            'supplier_phone' => $this->supplier_phone ? $this->supplier_phone : '',
            'supplier_address' => $this->supplier_address ? $this->supplier_address : '',
            'gst' => $this->gst ? $this->gst : '',
            'pan' => $this->pan ? $this->pan : '',
            'purchase_date' => $this->purchase_date ? Carbon::parse($this->purchase_date)->format('d-m-Y') : '',
            'note' => $this->note ? $this->note : '',
            'sub_total' => $this->sub_total ? number_format((float) ($this->sub_total), 2, '.', '') : '',
            'freight_charges' => $this->freight_charges ? number_format((float) ($this->freight_charges), 2, '.', '') : '',
            'adjustment' => $this->adjustment ? number_format((float) ($this->adjustment), 2, '.', '') : '',
            'discount' => $this->discount ? number_format((float) ($this->discount), 2, '.', '') : '',
            'total_items' => $this->total_items ? $this->total_items : '',
            'total' => $this->total ? number_format((float) ($this->total), 2, '.', '') : '',
            'roundoff' => $this->roundoff ? number_format((float) ($this->roundoff), 2, '.', '') : '',
            'grandtotal' => $this->grandtotal ? number_format((float) ($this->grandtotal), 2, '.', '') : '',
            'purchaseitem' => PurchaseitemResource::collection($this->purchaseitem),
        ];
    }
}
