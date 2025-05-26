<?php

namespace App\Http\Resources\Medicine;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineFrequencyResource extends JsonResource
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
            'frequency_type' => $this->frequency_type,
            'is_repeat' => $this->is_repeat,
            'till_turn_off' => $this->till_turn_off,
            'end_date' => $this->end_date?->format('Y-m-d'),
            'times' => $this->whenLoaded('times', function () {
                return $this->times->map(function ($time) {
                    return [
                        'id' => $time->id,
                        'time' => $time->time,
                    ];
                });
            }),
        ];
    }
}
