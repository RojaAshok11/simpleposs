<?php

namespace App\Http\Resources\Admin\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderholditemResource extends JsonResource
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
            'product_uuid' => $this->product_id ? $this->product->uuid : '',
            'product_name' => $this->product_id ? $this->product->name : '',
            'product_price' => $this->product_id ? number_format((float) ($this->product->sellingprice), 2, '.', '') : '',
            'quantity' => $this->quantity ? $this->quantity : '',
        ];
    }
}
