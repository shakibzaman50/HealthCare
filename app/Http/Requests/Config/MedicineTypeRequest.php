<?php

namespace App\Http\Requests\Config;

use App\Rules\UniqueMedicineType;
use Illuminate\Foundation\Http\FormRequest;

class MedicineTypeRequest extends FormRequest
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
        $medicineTypeId = $this->route('medicine_type');
        return [
            'name'      => ['required', 'max:30', new UniqueMedicineType($medicineTypeId)],
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
