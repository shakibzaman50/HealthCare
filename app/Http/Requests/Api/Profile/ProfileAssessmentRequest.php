<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileAssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'live_active_lifestyle' => 'required|boolean',
            'insulin_resistance' => 'required|boolean',
            'hypertension' => 'required|boolean',
            'activity_level_id' => 'nullable|exists:activity_levels,id',
            'hydration_goal' => 'nullable|integer|min:0',
            'physical_condition_id' => 'nullable|exists:physical_conditions,id',
        ];
    }
}