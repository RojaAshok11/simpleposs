<?php

namespace App\Http\Resources\Admin\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerorderhistoryResource extends JsonResource
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
            'total_items' => $this->total_items ? $this->total_items : '',
            'grandtotal' => $this->grandtotal ? number_format((float) ($this->grandtotal), 2, '.', '') : '',
            'mode' => $this->mode ? config('archive.mode')[$this->mode] : '',
        ];
    }
}
