<?php

namespace App\Services\Api;

use App\Models\HeartRate;

class HeartRateService
{
    public function store($request) : HeartRate
    {
        return HeartRate::create($request->all());
    }
}
