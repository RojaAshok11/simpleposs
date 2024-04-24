<?php

namespace App\Http\Resources\Admin\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderhistoryResource extends JsonResource
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
            'customer_name' => $this->customer_name ? $this->customer_name : '',
            'customer_phone' => $this->customer_phone ? $this->customer_phone : '',
            'total_items' => $this->total_items ? $this->total_items : '',
            'grandtotal' => $this->grandtotal ? number_format((float) ($this->grandtotal), 2, '.', '') : '',
            'mode' => $this->mode ? config('archive.mode')[$this->mode] : '',
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y h:i A') : '',
            'created_by' => $this->createdby?->name,
        ];
    }
}
