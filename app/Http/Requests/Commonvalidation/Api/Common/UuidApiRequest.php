<?php

namespace App\Http\Requests\Commonvalidation\Api\Common;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UuidApiRequest extends FormRequest
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
        $uuid = collect(request()->all())->keys()->first();
        return [
            $uuid => 'bail|required|string|max:50',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
