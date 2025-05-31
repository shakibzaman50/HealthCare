<?php

namespace App\Http\Resources\Api\WaterIntake;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WaterIntakeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'amount'   => $this->amount,
            'unit'     => $this->unit?->name,
            'done'     => $this->done.'%',
            'status'   => $this->status==1 ? 'Hydrated' : 'Dehydrated',
            'drink_at' => $this->drink_at,
        ];
    }
}
