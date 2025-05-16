<?php

namespace App\Services\Config;

use App\Models\SugarUnit;
use Illuminate\Support\Str;

class SugarUnitService
{
    protected function checkTrashed($name){
        return
            SugarUnit::withTrashed()
                ->where('name', Str::squish($name))
                ->first() ?? null;
    }

    public function create(array $data) : SugarUnit
    {
        $trashedUnit = $this->checkTrashed($data['name']);

        if($trashedUnit)
        {
            $trashedUnit->restore();
            return $trashedUnit;
        }
        else{
            return SugarUnit::create($data);
        }
    }

    public function update(SugarUnit $sugarUnit, array $data): SugarUnit
    {
        $sugarUnit->update($data);
        return $sugarUnit;
    }

    public function delete(SugarUnit $bpUnit): bool
    {
        return $bpUnit->delete();
    }
}
