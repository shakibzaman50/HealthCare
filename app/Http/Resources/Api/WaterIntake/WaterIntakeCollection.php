<?php

namespace App\Http\Resources\Api\WaterIntake;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WaterIntakeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => WaterIntakeResource::collection($this->collection),
            'meta' => [
                'current_page' => $this->currentPage(),
                'total' => $this->total(),
                'per_page' => $this->perPage(),
            ],
            'links' => [
                'next' => $this->nextPageUrl(),
                'prev' => $this->previousPageUrl(),
            ],
        ];
    }
}
