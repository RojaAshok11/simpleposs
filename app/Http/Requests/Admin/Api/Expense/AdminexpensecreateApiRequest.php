<?php

namespace App\Http\Requests\Admin\Api\Expense;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminexpensecreateApiRequest extends FormRequest
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
            "name" => 'bail|required|string|min:2|max:70',
            "date" => 'bail|required|date',
            "expensecategory_uuid" => 'bail|required|string|max:50',
            "amount" => 'bail|required|numeric|min:1|max:999999',
            "note" => 'bail|nullable|min:5|max:255',
            "active" => 'bail|nullable|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
