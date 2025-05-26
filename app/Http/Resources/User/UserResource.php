<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Profile\ProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'     => $this->name,
            'email'    => $this->email,
            'status'   => $this->getStatusText($this->status),
            'type'     => $this->getTypeText($this->type),
            'profiles' => ProfileResource::collection($this->whenLoaded('profiles')),
        ];
    }

    private function getStatusText($status)
    {
        $statuses = config('app.user_status');
        $flipped = array_flip($statuses);

        return $flipped[$status] ?? 'unknown';
    }

    private function getTypeText($type): string
    {
        $types   = config('app.user_type');
        $flipped = array_flip($types);

        return $flipped[$type] ?? 'unknown';
    }
}
