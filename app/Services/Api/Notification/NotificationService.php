<?php

namespace App\Services\Api\Notification;

use App\Models\Notification;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    public function createOrUpdate(Profile $profile, array $data): Model
    {
        $notification = $profile->notification()->first();

        if ($notification) {
            $notification->update($data);
            return $notification;
        }

        return $profile->notification()->create($data);
    }

    public function getByProfile(Profile $profile): ?Model
    {
        return $profile->notification()->first();
    }
}
