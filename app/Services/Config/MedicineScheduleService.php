<?php

namespace App\Services\Config;

use App\Models\MedicineSchedule;
use Illuminate\Support\Str;

class MedicineScheduleService
{
    protected function checkTrashed($name)
    {
        return MedicineSchedule::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : MedicineSchedule
    {
        $trashedSchedule = $this->checkTrashed($data['name']);

        if($trashedSchedule) {
            $trashedSchedule->restore();
            return $trashedSchedule;
        } else{
            return MedicineSchedule::create($data);
        }
    }

    public function update(MedicineSchedule $medicineSchedule, array $data): MedicineSchedule
    {
        $medicineSchedule->update($data);
        return $medicineSchedule;
    }

    public function delete(MedicineSchedule $medicineSchedule): bool
    {
        return $medicineSchedule->delete();
    }
}
