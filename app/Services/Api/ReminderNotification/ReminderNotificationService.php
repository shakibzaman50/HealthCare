<?php

namespace App\Services\Api\ReminderNotification;

use App\Models\ReminderNotification;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ReminderNotificationService
{
    public function createOrUpdate(Profile $profile, array $data): Model
    {
        $reminderNotification = $profile->reminderNotification()->first();

        if ($reminderNotification) {
            $reminderNotification->update($data);
            return $reminderNotification;
        }

        return $profile->reminderNotification()->create($data);
    }

    public function getByProfile(Profile $profile): ?Model
    {
        return $profile->reminderNotification()->first();
    }
}
