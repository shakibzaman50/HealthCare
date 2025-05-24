<?php

namespace App\Http\Resources\BsRecord;

use App\Http\Resources\SugarScheduleResource;
use App\Http\Resources\SugarUnitResource;
use App\Http\Resources\User\ProfileResource;
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
            'measured_at' => $this->measured_at->format('Y-m-d H:i:s'),
            // Include relationships if needed
            'sugar_schedule' => new SugarScheduleResource($this->whenLoaded('sugarSchedule')),
            'sugar_unit' => new SugarUnitResource($this->whenLoaded('sugarUnit')),
        ];
    }
}