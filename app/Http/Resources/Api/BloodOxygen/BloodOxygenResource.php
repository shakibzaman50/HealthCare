<?php

namespace App\Http\Resources\Api\BloodOxygen;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodOxygenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'oxygen_level' => $this->oxygen_level,
            'status'       => $this->status==1 ? 'Saturated' : 'Desaturated',
            'measured_at'  => $this->measured_at,
        ];
    }
}
