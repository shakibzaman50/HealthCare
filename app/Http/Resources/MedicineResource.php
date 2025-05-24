<?php

namespace App\Http\Resources;

use App\Http\Resources\User\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
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
            'profile_id' => $this->profile_id,
            'profile' => $this->whenLoaded('profile', ProfileResource::make($this->profile)),
            'name' => $this->name,
            'type' => $this->type,
            'medicine_type' => $this->medicineType,
            'strength' => $this->strength,
            'unit' => $this->unit,
            'medicine_unit' => $this->unit,
            'is_active' => $this->is_active,
            'notes' => $this->notes,
            'reminders' => MedicineReminderResource::collection($this->whenLoaded('reminders')),
        ];
    }
}