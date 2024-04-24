<?php

namespace App\Http\Resources\Admin\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerlistResource extends JsonResource
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
            'name' => $this->name ? $this->name : '',
            'phone' => $this->phone ? $this->phone : '',
            'email' => $this->email ? $this->email : '',
            'total_sale' => $this->sale->count() ? $this->sale->count() : '',
            'total_saleamount' => $this->sale->sum('grandtotal') ? number_format((float) ($this->sale->sum('grandtotal')), 2, '.', '') : '',
        ];
    }
}
