<?php

namespace App\Services\Api;

use App\Models\HydrationReminder;

class HydrationReminderService
{
    public function store($request) : HydrationReminder
    {
        return HydrationReminder::create($request->all());
    }
}
