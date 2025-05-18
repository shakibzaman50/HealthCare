<?php

namespace App\Services\Config;

use App\Models\WaterUnit;
use Illuminate\Support\Str;

class WaterUnitService
{
    protected function checkTrashed($name)
    {
        return WaterUnit::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : WaterUnit
    {
        $trashedUnit = $this->checkTrashed($data['name']);

        if($trashedUnit) {
            $trashedUnit->restore();
            return $trashedUnit;
        }
        else{
            return WaterUnit::create($data);
        }
    }

    public function update(WaterUnit $waterUnit, array $data): WaterUnit
    {
        $waterUnit->update($data);
        return $waterUnit;
    }

    public function delete(WaterUnit $waterUnit): bool
    {
        return $waterUnit->delete();
    }
}
