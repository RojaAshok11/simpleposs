<?php

namespace App\Http\Requests\Admin\Api\Fcm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FcmRequest extends FormRequest
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
            'device_token' => 'required|string',
            'device_model' => 'nullable|string',
            'device_brand' => 'nullable|string',
            'device_manufacturer' => 'nullable|string',

            'computer_name' => 'nullable|string',

            'no_of_cores' => 'nullable|string',
            'user_name' => 'nullable|string',
            'editionid' => 'nullable|string',
            'productid' => 'nullable|string',
            'product_name' => 'nullable|string',
            'register_owner' => 'nullable|string',
            'deviceid' => 'nullable|string',

            'host_name' => 'nullable|string',
            'arch' => 'nullable|string',
            'kernel_version' => 'nullable|string',
            'major_version' => 'nullable|string',
            'minor_version' => 'nullable|string',
            'patch_version' => 'nullable|string',
            'os_release' => 'nullable|string',
            'active_cpus' => 'nullable|string',
            'memory_size' => 'nullable|string',
            'cpu_frequency' => 'nullable|string',
            'system_guid' => 'nullable|string',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
