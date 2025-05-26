<?php

namespace App\Http\Resources\Api\BloodPressure;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodPressureResource extends JsonResource
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
            'systolic'    => $this->systolic,
            'diastolic'   => $this->diastolic,
            'unit'        => $this->unit?->name,
            'status'      => $this->status,
            'measured_at' => $this->measured_at,
        ];
    }
}
