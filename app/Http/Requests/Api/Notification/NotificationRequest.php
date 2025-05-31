<?php

namespace App\Http\Requests\Api\Notification;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'allow_all_notification' => 'required|boolean',
            'notification_snozing' => 'required|boolean',
            'notification_dot_on_app' => 'required|boolean',
            'reminder_notifications' => 'required|boolean'
        ];
    }
}
