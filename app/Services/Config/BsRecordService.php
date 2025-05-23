<?php

namespace App\Services\Config;

use App\Http\Resources\BsRecord\BsRecordCollection;
use App\Http\Resources\BsRecord\BsRecordResource;
use App\Models\BsRecord;

class BsRecordService
{
    function list()
    {
        return new BsRecordCollection(
            BsRecord::with(['profile', 'sugarSchedule', 'sugarUnit'])->paginate(15)
        );
    }

    function create(array $data)
    {
        return BsRecord::create($data);
    }
}