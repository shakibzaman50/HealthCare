<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'weight_unit' =>
            'nullable',
            'integer',
            Rule::exists('weight_units', 'id')
                ->where('is_active', config('basic.status.active')),
            'height_unit' => [
                'nullable',
                'integer',
                Rule::exists('height_units', 'id')
                    ->where('is_active', config('basic.status.active'))
            ],
            'height' => 'nullable|numeric|min:0',
            'birth_year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
            'bmi' => 'nullable|numeric|min:0',
            'gender' => 'nullable|string|in:male,female,other',
        ];

        // Add avatar validation rules based on the request method
        if ($this->isMethod('POST')) {
            $rules['avatar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['avatar'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'avatar.image' => 'The avatar must be an image file.',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg, gif.',
            'avatar.max' => 'The avatar may not be greater than 2MB.',
        ];
    }
}
