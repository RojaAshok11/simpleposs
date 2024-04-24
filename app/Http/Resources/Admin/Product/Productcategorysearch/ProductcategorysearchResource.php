<?php

namespace App\Http\Resources\Admin\Product\Productcategorysearch;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductcategorysearchResource extends JsonResource
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
            'name' => $this->name ? $this->name : '',
            'image' => $this->image ? $this->image : '',
        ];
    }
}
