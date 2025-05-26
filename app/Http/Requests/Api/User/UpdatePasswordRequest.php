<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed|different:old_password',
            'password_confirmation' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return [
            'password.different' => 'The new password must be different from the old password.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!Hash::check($this->old_password, auth()->user()->password)) {
                $validator->errors()->add('old_password', 'The old password is incorrect.');
            }
        });
    }
}