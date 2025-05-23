<?php

namespace App\Observers;

use App\Helpers\BsStatusCheck;
use App\Models\BsRecord;

class BsRecordObserver
{
    public function creating(BsRecord $bsRecord)
    {
        $bsRecord->status = BsStatusCheck::getBsStatus($bsRecord->value, $bsRecord->sugarSchedule->name, $bsRecord->sugarUnit->name);
    }
}
