<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $blogId = $this->route('blog');
        return [
            'title'     => ['required', 'max:250'],
            'tags'      => ['required', 'array', 'max:10'],
            'thumbnail' => [$blogId ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'content'   => ['required'],
        ];
    }
}
