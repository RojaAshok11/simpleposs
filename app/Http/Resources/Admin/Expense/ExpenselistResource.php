<?php

namespace App\Http\Resources\Admin\Expense;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenselistResource extends JsonResource
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
            'amount' => $this->amount ? number_format((float) ($this->amount), 2, '.', '') : '',
        ];
    }
}
