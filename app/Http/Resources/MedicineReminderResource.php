<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineReminderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medicine_id' => $this->medicine_id,
            'medicine' => $this->whenLoaded('medicine', MedicineResource::make($this->medicine)),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'is_repeat' => $this->is_repeat,
            'till_turn_off' => $this->till_turn_off,
            'schedules' => ReminderScheduleResource::collection($this->whenLoaded('schedules')),
            'schedule_times' => ReminderScheduleTimeResource::collection($this->whenLoaded('scheduleTimes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}