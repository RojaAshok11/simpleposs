<?php

namespace App\Http\Resources\Admin\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class ShoworderitemResource extends JsonResource
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
            'product_name' => $this->product_name ? $this->product_name : '',
            'quantity' => $this->quantity ? $this->quantity : '',
            'returned_quantity' => $this->salereturnitem->sum('return_quantity'),
            'price' => $this->price ?number_format((float) ($this->price), 2, '.', '') : '',
            'total' => $this->total ? number_format((float)$this->total, 2, '.', '') : '',
        ];
    }
}
