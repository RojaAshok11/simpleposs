<?php

namespace App\Http\Resources\Admin\Salereturn;

use Illuminate\Http\Resources\Json\JsonResource;

class SalereturnitemResource extends JsonResource
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
            'product_name' => $this->product->name ? $this->product->name : '',
            'return_quantity' => $this->return_quantity ? $this->return_quantity : '',
            'total' => $this->total ? number_format((float) ($this->total), 2, '.', '')  : '',
        ];
    }
}
