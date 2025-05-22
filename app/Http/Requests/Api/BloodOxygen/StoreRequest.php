<?php

namespace App\Http\Requests\Api\BloodOxygen;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oxygen_level' => ['required', 'integer', 'between:1,100'],
            'measured_at'  => ['required', 'date_format:Y-m-d H:i'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'profile_id' => $this->route('profile_id'),
        ]);
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'data'    => null,
            'errors'  => $validator->errors(),
        ], 422));
    }
}
