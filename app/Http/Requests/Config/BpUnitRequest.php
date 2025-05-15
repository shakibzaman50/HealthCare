<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BpUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // You can use different rules depending on the HTTP method
        // Optional: add custom logic based on `request()->routeIs()`

        $bpUnitId = $this->route('bp_unit'); // Assuming route model binding or parameter is named `bp_unit`

        return [
            'name' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('bp_units', 'name')
                    ->ignore($bpUnitId)
                    ->whereNull('deleted_at'),
            ],
            'is_active' => 'boolean|nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
