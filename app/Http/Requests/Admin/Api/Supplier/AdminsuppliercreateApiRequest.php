<?php

namespace App\Http\Requests\Admin\Api\Supplier;

use App\Models\Admin\Supplier\Supplier;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminsuppliercreateApiRequest extends FormRequest
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
        $supplier = Supplier::where('uuid', request()->uuid)->first();
        return [
            'uuid' => 'bail|nullable|string|max:50',
            'name' => 'required|string|min:2|max:70',
            'phone' => 'required|digits:10|unique:suppliers,phone,' . $supplier?->id,
            'email' => 'required|email|unique:suppliers,email,' . $supplier?->id,
            'gst' => 'nullable|string|size:15',
            'pan' => 'nullable|string|size:10',
            'cpname' => 'nullable|string|min:4|max:70',
            'cpphone' => 'nullable|digits:10|unique:suppliers,cpphone,' . $supplier?->id,
            'cpmail' => 'nullable|email',
            'address' => 'required|string|min:5|max:255',
            'note' => 'nullable|min:5|max:255',
            'active' => 'nullable|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
