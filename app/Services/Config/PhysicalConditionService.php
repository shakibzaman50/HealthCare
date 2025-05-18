<?php

namespace App\Services\Config;

use App\Models\PhysicalCondition;

class PhysicalConditionService
{
    public function create(array $data): PhysicalCondition
    {
        return PhysicalCondition::create($data);
    }

    public function update(PhysicalCondition $physicalCondition, array $data): PhysicalCondition
    {
        $physicalCondition->update($data);
        return $physicalCondition;
    }

    public function delete(PhysicalCondition $physicalCondition): void
    {
        $physicalCondition->delete();
    }
}
