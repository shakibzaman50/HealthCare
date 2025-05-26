<?php

namespace App\Observers;

use App\Models\BloodSugar;
use App\Helpers\BloodSugarStatus;

class BloodSugarObserver
{
    public function creating(BloodSugar $bloodSugar)
    {
        $bloodSugar->status = BloodSugarStatus::check($bloodSugar->value, $bloodSugar->sugar_schedule_id, $bloodSugar->sugar_unit_id)['category'];
    }
}
