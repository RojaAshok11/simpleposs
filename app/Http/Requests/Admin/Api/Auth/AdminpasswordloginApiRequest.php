<?php

namespace App\Http\Requests\Admin\Api\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminpasswordloginApiRequest extends FormRequest
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
            'phone' => 'bail|required|digits:10',
            'password' => 'bail|required|min:8',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }

}
