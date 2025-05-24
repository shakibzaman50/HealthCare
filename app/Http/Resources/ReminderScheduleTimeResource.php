<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderScheduleTimeResource extends JsonResource
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
            'schedule_id' => $this->schedule_id,
            'schedule' => $this->whenLoaded('schedule', ReminderScheduleResource::make($this->schedule)),
            'time' => $this->time?->format('H:i'),
            'label' => $this->label,
            'is_active' => $this->is_active,
        ];
    }
}