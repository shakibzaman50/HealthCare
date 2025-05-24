<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderScheduleResource extends JsonResource
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
            'reminder_id' => $this->reminder_id,
            'reminder' => $this->whenLoaded('reminder', ReminderScheduleTimeResource::make($this->reminder)),
            'schedule_type' => $this->schedule_type?->value,
            'how_many_times' => $this->how_many_times,
            'schedule_times' => ReminderScheduleTimeResource::collection($this->whenLoaded('scheduleTimes')),
        ];
    }
}