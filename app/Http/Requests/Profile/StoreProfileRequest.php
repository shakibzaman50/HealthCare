<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to true to allow all users (or apply logic)
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|string',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'dob' => 'nullable|date',
            'bmi' => 'nullable|numeric|min:0',
        ];
    }
}
