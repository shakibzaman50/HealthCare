<?php

namespace App\Services\Config;

use App\Models\HeartRateUnit;
use Illuminate\Support\Facades\DB;

class HeartRateUnitService
{
    public function create(array $data): HeartRateUnit
    {
        return HeartRateUnit::create($data);
    }

    public function update(HeartRateUnit $heartRateUnit, array $data): HeartRateUnit
    {
        $heartRateUnit->update($data);
        return $heartRateUnit;
    }

    public function delete(HeartRateUnit $heartRateUnit): void
    {
        $heartRateUnit->delete();
    }
}
