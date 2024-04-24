<?php

namespace App\Http\Requests\Admin\Api\Profile;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminupdateprofileApiRequest extends FormRequest
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
            'name' => 'bail|required|string|max:30',
            'hospital_address' => 'bail|required|min:3|max:255',
            'hospital_mobile' => 'bail|required|digits:10|unique:hospitals,hospital_mobile,' . auth()->id(),
            'hospital_landline' => 'bail|required',
            'hospital_areauuid' => 'bail|required|string|max:50',
            'hospital_email' => 'bail|required|string|email|without_spaces|unique:hospitals,hospital_email,' . auth()->id(),
            'hospital_website' => 'nullable',
            'head_name' => 'bail|required|max:30',
            'head_mobile' => 'bail|required|digits:10',
            'head_email' => 'bail|required|email|without_spaces',
            'alternative_name' => 'nullable|max:30',
            'alternative_mobile' => 'bail|nullable|digits:10',
            'alternative_email' => 'nullable|email|without_spaces',
            'latitude' => 'required|between:-90,90',
            'longitude' => 'required|between:-180,180',

        ];
    }

    public function messages()
    {
        return [
            'hospital_areauuid.required' => 'Select an Area',
            'hospital_email.without_spaces' => 'Invalid Email',
            'head_email.without_spaces' => 'Invalid Email',
            'alternative_email.without_spaces' => 'Invalid Email',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
