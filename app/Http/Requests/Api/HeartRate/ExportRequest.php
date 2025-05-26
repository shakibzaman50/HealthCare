<?php

namespace App\Http\Requests\Api\HeartRate;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ExportRequest extends FormRequest
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
    public function rules(): array {
        return [
            'file'      => ['required', 'string', 'in:pdf,csv'],
            'from_date' => ['required', 'before:to_date', 'date_format:Y-m-d'],
            'to_date'   => ['required', 'after:from_date', 'date_format:Y-m-d']
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
