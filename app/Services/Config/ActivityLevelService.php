<?php

namespace App\Services\Config;

use App\Models\ActivityLevel;
use Illuminate\Support\Str;

class ActivityLevelService
{
    protected function checkTrashed($name)
    {
        return ActivityLevel::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : ActivityLevel
    {
        $trashedActivity = $this->checkTrashed($data['name']);

        if($trashedActivity) {
            $trashedActivity->restore();
            return $trashedActivity;
        } else {
            return ActivityLevel::create($data);
        }
    }

    public function update(ActivityLevel $activityLevel, array $data): ActivityLevel
    {
        $activityLevel->update($data);
        return $activityLevel;
    }

    public function delete(ActivityLevel $activityLevel): bool
    {
        return $activityLevel->delete();
    }
}
