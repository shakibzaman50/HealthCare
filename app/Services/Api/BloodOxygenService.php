<?php

namespace App\Services\Api;

use App\Models\BloodOxygen;

class BloodOxygenService
{
    public function store($request) : BloodOxygen
    {
        return BloodOxygen::create($request->all());
    }
}
