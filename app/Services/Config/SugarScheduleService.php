<?php

namespace App\Services\Config;

use App\Models\SugarSchedule;
use Illuminate\Support\Str;

class SugarScheduleService
{
    protected function checkTrashed($name)
    {
        return SugarSchedule::withTrashed()
            ->where('name', Str::squish($name))
            ->first() ?? null;
    }

    public function create(array $data) : SugarSchedule
    {
        $trashedSchedule = $this->checkTrashed($data['name']);

        if($trashedSchedule) {
            $trashedSchedule->restore();
            return $trashedSchedule;
        } else{
            return SugarSchedule::create($data);
        }
    }

    public function update(SugarSchedule $sugarSchedule, array $data): SugarSchedule
    {
        $sugarSchedule->update($data);
        return $sugarSchedule;
    }

    public function delete(SugarSchedule $sugarSchedule): bool
    {
        return $sugarSchedule->delete();
    }
}
