<?php

namespace App\Http\Requests\Admin;

use App\Rules\UniqueHabitList;
use App\Rules\UniqueHabitTask;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HabitTaskRequest extends FormRequest
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
        $habitListId = $this->input('habit_list_id');
        $habitTaskId = $this->route('habit_task');
        return [
            'name'          => ['required', 'max:50', new UniqueHabitTask($habitListId, $habitTaskId)],
            'icon'          => [$habitTaskId ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'is_active'     => ['nullable', 'boolean'],
            'habit_list_id' => ['required', 'integer', Rule::exists('habit_lists', 'id')
                ->where('is_active', config('basic.status.active'))
            ],
        ];
    }
}
