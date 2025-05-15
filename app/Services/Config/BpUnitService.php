<?php

namespace App\Services\Config;

use App\Models\BpUnit;

class BpUnitService
{
    public function create(array $data): BpUnit
    {
        return BpUnit::create($data);
    }

    public function update(BpUnit $bpUnit, array $data): BpUnit
    {
        $bpUnit->update($data);
        return $bpUnit;
    }

    public function delete(BpUnit $bpUnit): bool
    {
        return $bpUnit->delete();
    }
}
