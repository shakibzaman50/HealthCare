<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueHabitList;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HabitListRequest extends FormRequest
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
        $habitListId = $this->route('habit_list');
        return [
            'name'      => ['required', 'max:50', new UniqueHabitList($habitListId)],
            'icon'      => [$habitListId ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
