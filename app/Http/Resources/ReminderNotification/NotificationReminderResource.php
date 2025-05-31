<?php

namespace App\Http\Resources\ReminderNotification;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationReminderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'heart_beat' => $this->heart_beat,
            'blood_presure' => $this->blood_presure,
            'blood_sugar' => $this->blood_sugar,
            'water_intake' => $this->water_intake,
            'habit_tracker' => $this->habit_tracker,
            'medication' => $this->medication,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}