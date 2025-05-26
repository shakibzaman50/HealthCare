<?php

namespace App\Http\Requests\Api\HabitReminder;

use App\Rules\Api\DaysSchedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class TaskStoreRequest extends FormRequest
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
            'habit_task_id' => ['required', 'integer', Rule::exists('habit_tasks', 'id')
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
}

////            'name'          => ['required', 'max:50'],
////            'icon'          => [$habitTaskId ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
////            'habit_list_id' => ['required', 'integer', Rule::exists('habit_lists', 'id')
////                ->where('is_active', config('basic.status.active'))
////            ],
////
////            //Schedule
////            'type' => ['required', 'boolean'],
////            'color' => ['required', 'string', 'max:20'],
////            'description' => ['required', 'string', 'max:255'],
////            'duration' => ['required', 'date_format:h:i'],
////            'end_date' => ['required', 'date_format:Y-m-d'],
////            'is_repeat' => ['required', 'boolean'],
////            'till_turn_off' => ['required', 'boolean'],
////
////            // Frequency
////            'day' => ['required', 'array', 'max:6', new DaysSchedule()],
////            'day.*' => ['required', 'in:EVERY,SAT,SUN,MON,TUE,WED,THU,FRI'],
////            'how_many_times' => ['required', 'array', 'max:6'],
////            'how_many_times.*' => ['required', 'integer', 'between:1,12'],
////
////            // Reminder
//        ];
//    }
//}



//{
//  "habit_list_id": "1",
//  "name": "New Task Name",
//  "icon": "Icon",
//  "type": "1",
//  "color": "red",
//  "description": "New Task Description",
//  "duration": "10:00",
//  "end_date": "2021-01-01",
//  "is_repeat": "1",
//  "till_turn_off": "1",
//  "frequency": [
//    {
//      "id": 1,
//      "day": "SAT",
//      "how_many_times": 1,
//      "reminder_times": [
//        {
//          "id": 1,
//          "time": "08:30"
//        }
//      ]
//    },
//    {
//      "id": 2,
//      "day": "MON",
//      "how_many_times": 3,
//      "reminder_times": [
//        {
//          "id": 1,
//          "time": "08:30"
//        },
//        {
//          "id": 2,
//          "time": "12:30"
//        },
//        {
//          "id": 3,
//          "time": "20:30"
//        }
//      ]
//    },
//    {
//      "id": 3,
//      "day": "FRI",
//      "how_many_times": 2,
//      "reminder_times": [
//        {
//          "id": 2,
//          "time": "11:30"
//        },
//        {
//          "id": 3,
//          "time": "22:30"
//        }
//      ]
//    }
//  ]
//}
