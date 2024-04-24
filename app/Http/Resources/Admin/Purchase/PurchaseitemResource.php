<?php

namespace App\Http\Resources\Admin\Purchase;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseitemResource extends JsonResource
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
            'product_name' => $this->product_name ? $this->product_name : '',
            'quantity' => $this->quantity ? $this->quantity : '',
            'price' => $this->price ? number_format((float) ($this->price), 2, '.', '') : '',
            'total' => $this->total ? number_format((float) ($this->total), 2, '.', '') : '',
        ];
    }
}
