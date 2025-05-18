<?php

namespace App\Http\Requests\Config;

use App\Rules\UniqueSugarUnit;
use Illuminate\Foundation\Http\FormRequest;

class SugarUnitRequest extends FormRequest
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
        $sugarUnitId = $this->route('sugar_unit');
        return [
            'name'      => ['required', 'max:20', new UniqueSugarUnit($sugarUnitId)],
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
