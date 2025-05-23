<?php

namespace App\Services\Api;

use App\Models\BloodPressure;

class BloodPressureService
{
    public function store($request) : BloodPressure
    {
        return BloodPressure::create($request->all());
    }
}
