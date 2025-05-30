<?php

namespace App\Http\Resources\Api\HabitTracker;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->habitTask?->name,
            'duration'    => Carbon::parse($this->duration)->format('H:i'),
            'description' => $this->description,
            'end_date'    => $this->end_date,
        ];
    }
}
