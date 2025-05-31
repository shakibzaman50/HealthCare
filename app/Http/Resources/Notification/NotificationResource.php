<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'allow_all_notification' => $this->allow_all_notification,
            'notification_snozing' => $this->notification_snozing,
            'notification_dot_on_app' => $this->notification_dot_on_app,
            'reminder_notifications' => $this->reminder_notifications,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
