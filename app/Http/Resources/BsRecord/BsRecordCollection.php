<?php

namespace App\Http\Resources\BsRecord;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BsRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->resource;
    }
}
