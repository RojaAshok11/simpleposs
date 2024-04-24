<?php

namespace App\Http\Requests\Admin\Api\Customer;

use App\Models\Admin\Customer\Customer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdmincreatecustomerApiRequest extends FormRequest
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
        $customer = Customer::where('uuid', request()->uuid)->first();
        return [
            'uuid' => 'bail|nullable|string|max:50',
            'name' => 'bail|required|string|min:2|max:70',
            'phone' => 'bail|required|digits:10|unique:customers,phone,' . $customer?->id,
            'email' => 'bail|nullable|email|unique:customers,email,' . $customer?->id,
            'active' => 'bail|nullable|boolean',
            'note' => 'bail|nullable|min:5|max:255',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
