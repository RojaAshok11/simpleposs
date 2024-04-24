<?php

namespace App\Http\Requests\Admin\Api\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdmincreateproductApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'uuid' => 'bail|nullable|string|max:50',
            'name' => 'bail|required|string|min:2|max:70',
            'productcategory_uuid' => 'bail|required|string|max:50',
            'purchaseprice' => 'bail|required|numeric|min:1|max:999999',
            'sellingprice' => 'bail|required|numeric|min:1|max:999999',
            'sku' => 'bail|required|string|min:2|max:70',
            'image' => 'bail|nullable|mimes:jpeg,png,jpg|max:10240',
            'uom_uuid' => 'bail|required|string|max:50',
            'note' => 'bail|nullable|min:5|max:255',
            'active' => 'bail|nullable|boolean',
            'cgst' => 'bail|nullable|numeric|max:9999',
            'sgst' => 'bail|nullable|numeric|max:9999',
            'igst' => 'bail|nullable|numeric|max:9999',
            'cess' => 'bail|nullable|numeric|max:9999',
            'hsncode' => 'bail|nullable|numeric|max:9999',
            'is_nonveg' => 'bail|nullable|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
