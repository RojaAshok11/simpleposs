<?php

namespace App\Http\Resources\Admin\Supplier;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierlistResource extends JsonResource
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
        ];
    }
}
