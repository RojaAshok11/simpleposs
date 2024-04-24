<?php

namespace App\Http\Requests\Commonvalidation\Api\Common;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class StatusRequest extends FormRequest
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

        $status = collect(request()->all())->keys()->slice(1, 1)[1];

        switch ($status) {
            case "active":
                return [
                    collect(request()->all())->keys()->first() => 'bail|required|string|max:50',
                    $status => 'bail|required|boolean',
                ];
                break;
            case "status":
                return [
                    collect(request()->all())->keys()->first() => 'bail|required|string|max:50',
                    $status => 'bail|required|integer',
                ];
                break;
            case "type":
                return [
                    collect(request()->all())->keys()->first() => 'bail|required|string|max:50',
                    $status => 'bail|required|string|max:100',
                ];
                break;
            default:
                Log::info('StatusupdateRequest Invalid Request');
                return;
        }

    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->error(['Validation Error.', $validator->errors()], 404)
        );
    }
}
