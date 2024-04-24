<?php

namespace App\Http\Resources\Admin\Order;

use App\Http\Resources\Admin\Order\OrderholditemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderholdbyuuidResource extends JsonResource
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
            'reference_id' => $this->reference_id ? $this->reference_id : '',
            'is_hold' => true,
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y h:i A') : '',
            'created_by' => $this->createdby?->name,
            'orderholditem' => OrderholditemResource::collection($this->saleholditem),
        ];
    }
}
