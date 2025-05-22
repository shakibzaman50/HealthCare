<?php

namespace App\Http\Requests\Api\BloodPressure;

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
            'profile_id'  => ['required', 'integer', Rule::exists('profiles', 'id')
                ->where('user_id', Auth::id())
            ],
            'unit_id'     => ['required', 'integer', Rule::exists('bp_units', 'id')
                ->where('is_active', config('basic.status.active'))
            ],
            'systolic'    => ['required', 'integer', 'between:20,300', 'gt:diastolic'],
            'diastolic'   => ['required', 'integer', 'between:10,200', 'lt:systolic'],
            'measured_at' => ['required', 'date_format:Y-m-d H:i'],
        ];
    }

    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'data'    => null,
            'errors'  => $validator->errors(),
        ], 422));
    }
}
