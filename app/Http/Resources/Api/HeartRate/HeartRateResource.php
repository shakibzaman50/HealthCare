<?php

namespace App\Http\Resources\Api\HeartRate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeartRateResource extends JsonResource
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
            'heart_rate'  => $this->heart_rate,
            'unit'        => $this->unit?->name,
            'status'      => $this->status,
            'hrv'         => $this->hrv,
            'hrv_status'  => $this->hrv_status,
            'stress'      => $this->stress,
            'measured_at' => $this->measured_at,
        ];
    }
}
