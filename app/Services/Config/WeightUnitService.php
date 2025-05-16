<?php

namespace App\Services\Config;

use App\Models\WeightUnit;
use Illuminate\Support\Str;

class WeightUnitService
{
    protected function checkTrashed($name)
    {
        return WeightUnit::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : WeightUnit
    {
        $trashedUnit = $this->checkTrashed($data['name']);

        if($trashedUnit)
        {
            $trashedUnit->restore();
            return $trashedUnit;
        }
        else{
            return WeightUnit::create($data);
        }
    }

    public function update(WeightUnit $weightUnit, array $data): WeightUnit
    {
        $weightUnit->update($data);
        return $weightUnit;
    }

    public function delete(WeightUnit $weightUnit): bool
    {
        return $weightUnit->delete();
    }
}
