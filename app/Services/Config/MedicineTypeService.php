<?php

namespace App\Services\Config;

use App\Models\MedicineType;
use Illuminate\Support\Str;

class MedicineTypeService
{
    protected function checkTrashed($name)
    {
        return MedicineType::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : MedicineType
    {
        $trashedType = $this->checkTrashed($data['name']);

        if($trashedType) {
            $trashedType->restore();
            return $trashedType;
        } else{
            return MedicineType::create($data);
        }
    }

    public function update(MedicineType $medicineType, array $data): MedicineType
    {
        $medicineType->update($data);
        return $medicineType;
    }

    public function delete(MedicineType $medicineType): bool
    {
        return $medicineType->delete();
    }
}
