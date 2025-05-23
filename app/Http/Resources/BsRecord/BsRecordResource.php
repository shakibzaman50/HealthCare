<?php

namespace App\Http\Resources\BsRecord;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BsRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'sugar_schedule_id' => $this->sugar_schedule_id,
            'sugar_unit_id' => $this->sugar_unit_id,
            'value' => $this->value,
            'status' => $this->status,
            'measurement_at' => $this->measurement_at,
            // Include relationships if needed
            'profile' => $this->whenLoaded('profile'),
            'sugar_schedule' => $this->whenLoaded('sugarSchedule'),
            'sugar_unit' => $this->whenLoaded('sugarUnit'),
        ];
    }
}