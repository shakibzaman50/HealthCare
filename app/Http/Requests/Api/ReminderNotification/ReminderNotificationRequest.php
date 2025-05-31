<?php

namespace App\Http\Requests\Api\ReminderNotification;

use Illuminate\Foundation\Http\FormRequest;

class ReminderNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'heart_beat' => 'required|boolean',
            'blood_presure' => 'required|boolean',
            'blood_sugar' => 'required|boolean',
            'water_intake' => 'required|boolean',
            'habit_tracker' => 'required|boolean',
            'medication' => 'required|boolean'
        ];
    }
}
