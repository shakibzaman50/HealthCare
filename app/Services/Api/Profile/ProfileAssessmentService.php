<?php

namespace App\Services\Api\Profile;

use App\Models\ProfileAssessment;

class ProfileAssessmentService
{
    public function createOrUpdate(int $profileId, array $data): ProfileAssessment
    {
        return ProfileAssessment::updateOrCreate(
            ['profile_id' => $profileId],
            [
                'live_active_lifestyle' => $data['live_active_lifestyle'],
                'insulin_resistance' => $data['insulin_resistance'],
                'hypertension' => $data['hypertension'],
                'activity_level_id' => $data['activity_level_id'] ?? null,
                'hydration_goal' => $data['hydration_goal'] ?? null,
                'physical_condition_id' => $data['physical_condition_id'] ?? null,
            ]
        );
    }

    public function getByProfileId(int $profileId): ?ProfileAssessment
    {
        return ProfileAssessment::where('profile_id', $profileId)->first();
    }
}