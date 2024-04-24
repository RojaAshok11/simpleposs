<?php

namespace App\Http\Resources\Admin\Product\Productsearch;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class ProductsearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tax_type = App::make('possetting')->tax_type;
        switch ($tax_type) {
            case 1:
                $sellingprice = $this->sellingprice;
                break;
            case 2:
                $sellingprice = $this->sellingprice + ((($this->cgst / 100) * $this->sellingprice) + (($this->sgst / 100) * $this->sellingprice));
                break;
            case 3:
                $sellingprice = $this->sellingprice+(($this->vat / 100) * $this->sellingprice);
                break;
        }
        return [
            'uuid' => $this->uuid ? $this->uuid : '',
            'uniqid' => $this->uniqid ? $this->uniqid : '',
            'name' => $this->name ? $this->name : '',
            'sellingprice' => number_format((float) ($sellingprice), 2, '.', ''),
            'image' => $this->image ? $this->image : '',
            'stock' => $this->stock ? $this->stock : '',
            'is_nonveg' => $this->is_nonveg ? true : false,
        ];
    }
}
