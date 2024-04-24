<?php

namespace App\Http\Resources\Admin\Salereturn;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Salereturn\SalereturnitemResource;

class ShowsalereturnResource extends JsonResource
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
            'return_note' => $this->return_note ? $this->return_note : '',
            'grandtotal' => $this->grandtotal ? number_format((float) ($this->grandtotal), 2, '.', '')  : '',
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y h:i A')  : '',
            'created_by' => $this->createdby ? $this->createdby->name  : '',
            'salereturnitem' => SalereturnitemResource::collection($this->salereturnitem),
        ];
    }
}
