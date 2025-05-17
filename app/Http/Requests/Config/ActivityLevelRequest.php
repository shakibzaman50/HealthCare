<?php

namespace App\Http\Requests\Config;

use App\Rules\UniqueActivityLevel;
use Illuminate\Foundation\Http\FormRequest;

class ActivityLevelRequest extends FormRequest
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
        $activityLevelId = $this->route('activity_level');
        return [
            'name'      => ['required', 'max:30', new UniqueActivityLevel($activityLevelId)],
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
