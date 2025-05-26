<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileAssessmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'live_active_lifestyle' => $this->live_active_lifestyle,
            'insulin_resistance' => $this->insulin_resistance,
            'hypertension' => $this->hypertension,
            'activity_level_id' => $this->activityLevel->name,
            'hydration_goal' => $this->hydration_goal,
            'physical_condition_id' => $this->physicalCondition->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
