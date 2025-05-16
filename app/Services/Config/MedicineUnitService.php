<?php

namespace App\Services\Config;

use App\Models\MedicineUnit;
use Illuminate\Support\Str;

class MedicineUnitService
{
    protected function checkTrashed($name)
    {
        return MedicineUnit::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : MedicineUnit
    {
        $trashedUnit = $this->checkTrashed($data['name']);

        if($trashedUnit)
        {
            $trashedUnit->restore();
            return $trashedUnit;
        }
        else{
            return MedicineUnit::create($data);
        }
    }

    public function update(MedicineUnit $medicineUnit, array $data): MedicineUnit
    {
        $medicineUnit->update($data);
        return $medicineUnit;
    }

    public function delete(MedicineUnit $medicineUnit): bool
    {
        return $medicineUnit->delete();
    }
}
