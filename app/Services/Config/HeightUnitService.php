<?php

namespace App\Services\Config;

use App\Models\HeightUnit;
use Illuminate\Support\Str;

class HeightUnitService
{
    protected function checkTrashed($name)
    {
        return HeightUnit::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : HeightUnit
    {
        $trashedUnit = $this->checkTrashed($data['name']);

        if($trashedUnit) {
            $trashedUnit->restore();
            return $trashedUnit;
        } else{
            return HeightUnit::create($data);
        }
    }

    public function update(HeightUnit $heightUnit, array $data): HeightUnit
    {
        $heightUnit->update($data);
        return $heightUnit;
    }

    public function delete(HeightUnit $heightUnit): bool
    {
        return $heightUnit->delete();
    }
}
