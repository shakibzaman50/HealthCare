<?php

namespace App\Http\Requests\Config;

use App\Rules\UniqueWeightUnit;
use Illuminate\Foundation\Http\FormRequest;

class WeightUnitRequest extends FormRequest
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
        $weightUnitId = $this->route('weight_unit');
        return [
            'name'      => ['required', 'max:20', new UniqueWeightUnit($weightUnitId)],
            'is_active' => ['nullable', 'boolean']
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
