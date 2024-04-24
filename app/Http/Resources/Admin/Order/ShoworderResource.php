<?php

namespace App\Http\Resources\Admin\Order;

use App\Http\Resources\Admin\Order\ShoworderitemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoworderResource extends JsonResource
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
            'uniqid' => $this->uniqid ? $this->uniqid : '',
            'uuid' => $this->uuid ? $this->uuid : '',
            'customer_uuid' => $this->customer_id ? $this->customer->uuid : '',
            'customer_name' => $this->customer_name ? $this->customer_name : '',
            'customer_phone' => $this->customer_phone ? $this->customer_phone : '',
            'customer_email' => $this->customer_id ? $this->customer->email : '',
            'total_items' => $this->total_items ? $this->total_items : '',
            'sub_total' => $this->sub_total ? number_format((float)$this->sub_total, 2, '.', '') : '',
            'extra_charges' => $this->extra_charges ? number_format((float)$this->extra_charges, 2, '.', '') : '',
            'discount' => $this->discount ? number_format((float)$this->discount, 2, '.', '') : '',
            'total' => $this->total ? number_format((float)$this->total, 2, '.', '') : '',
            'roundoff' => $this->roundoff ? number_format((float)$this->roundoff, 2, '.', '') : '',
            'received_amount' => $this->received_amount ? number_format((float)$this->received_amount, 2, '.', '') : '',
            'remaining_amount' => $this->remaining_amount ? number_format((float)$this->remaining_amount, 2, '.', '') : '',
            'grandtotal' => $this->grandtotal ? number_format((float)$this->grandtotal, 2, '.', '') : '',
            'mode' => $this->mode ? config('archive.mode')[$this->mode] : '',
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y h:i A') : '',
            'created_by' => $this->createdby?->name,
            'orderlist' => ShoworderitemResource::collection($this->saleitem),
        ];
    }
}
