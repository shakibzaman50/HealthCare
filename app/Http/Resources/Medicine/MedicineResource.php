<?php

namespace App\Http\Resources\Medicine;

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
            'name' => $this->name,
            'strength' => $this->strength,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'medicine_type' => $this->whenLoaded('medicineType', function () {
                return [
                    'id' => $this->medicineType->id,
                    'name' => $this->medicineType->name,
                ];
            }),
            'medicine_unit' => $this->whenLoaded('medicineUnit', function () {
                return [
                    'id' => $this->medicineUnit->id,
                    'name' => $this->medicineUnit->name,
                ];
            }),
            'frequencies' => $this->whenLoaded('frequencies', MedicineFrequencyResource::collection($this->frequencies)),
        ];
    }
}
