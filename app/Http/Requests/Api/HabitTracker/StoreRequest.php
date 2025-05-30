<?php

namespace App\Http\Requests\Api\HabitTracker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
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
            // Task-level
            'habit_list_id' => ['nullable', 'integer', Rule::exists('habit_lists', 'id')
                ->where('is_active', config('basic.status.active')),
            ],
            'name'          => [$habitListId ? 'required' : 'nullable', 'max:50'],
            'icon'          => [$habitListId ? 'required' : 'nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'habit_task_id' => [$habitListId ? 'nullable' : 'required', 'integer', Rule::exists('habit_tasks', 'id')
                ->where('is_active', config('basic.status.active'))
            ],
            // Schedule-level
            'type'          => ['required', 'boolean'],
            'color'         => ['required', 'string', 'max:20'],
            'description'   => ['required', 'string', 'max:255'],
            'duration'      => ['required', 'date_format:H:i'],
            'end_date'      => ['required', 'date_format:Y-m-d'],
            'is_repeat'     => ['nullable', 'boolean'],
            'till_turn_off' => ['nullable', 'boolean'],

            // Frequency & Reminders
            'frequency'                         => ['required', 'array', 'max:6'],
            'frequency.*.day'                   => ['required', 'in:EVERY,SAT,SUN,MON,TUE,WED,THU,FRI'],
            'frequency.*.how_many_times'        => ['required', 'integer', 'between:1,12'],
            'frequency.*.reminder_times'        => ['required', 'array'],
            'frequency.*.reminder_times.*.time' => ['required', 'date_format:H:i'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $frequencies = $this->input('frequency', []);

            foreach ($frequencies as $index => $frequency) {
                $expectedCount = (int) ($frequency['how_many_times'] ?? 0);
                $actualCount = count($frequency['reminder_times'] ?? []);

                if ($expectedCount !== $actualCount) {
                    $validator->errors()->add(
                        "frequency.$index.reminder_times",
                        "The size of reminder times must equal with how_many_times ($expectedCount)."
                    );
                }
            }
        });
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'data'    => null,
            'errors'  => $validator->errors(),
        ], 422));
    }
}
