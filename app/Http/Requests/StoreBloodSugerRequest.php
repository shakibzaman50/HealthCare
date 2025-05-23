<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBloodSugerRequest extends FormRequest
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
            'profile_id' => ['required', 'exists:profiles,id'],
            'sugar_schedule_id' => ['required', 'exists:sugar_schedules,id'],
            'sugar_unit_id' => ['required', 'exists:sugar_units,id'],
            'value' => ['required', 'numeric', 'between:0,200'],
            'measured_at' => ['required', 'date']
        ];
    }
}
