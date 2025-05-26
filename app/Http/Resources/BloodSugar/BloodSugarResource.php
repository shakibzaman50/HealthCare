<?php

namespace App\Http\Resources\BloodSugar;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodSugarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'status' => $this->status,
            'measured_at' => $this->measured_at->format('Y-m-d H:i:s'),
            // Include relationships if needed
            'sugar_schedule' =>$this->whenLoaded('sugarSchedule', new SugarScheduleResource($this->sugarSchedule)),
            'sugar_unit' =>$this->whenLoaded('sugarUnit', new SugarUnitResource($this->sugarUnit)),
        ];
    }
}
