<?php

namespace App\Http\Resources\Admin\Purchase;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaselistResource extends JsonResource
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
            'supplier_name' => $this->supplier_name ? $this->supplier_name : '',
            'supplier_phone' => $this->supplier_phone ? $this->supplier_phone : '',
            'total_items' => $this->total_items ? $this->total_items : '',
            'grandtotal' => $this->grandtotal ? number_format((float) ($this->grandtotal), 2, '.', '')  : '',
        ];
    }
}
