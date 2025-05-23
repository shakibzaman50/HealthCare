<?php

namespace App\Http\Requests\BsRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreBsRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profile_id' => ['required', 'exists:profiles,id'],
            'sugar_schedule_id' => ['required', 'exists:sugar_schedules,id'],
            'sugar_unit_id' => ['required', 'exists:sugar_units,id'],
            'value' => ['required', 'numeric', 'between:0,200'],
            'measurement_at' => ['required', 'date'],
        ];
    }
}