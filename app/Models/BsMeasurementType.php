<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BsMeasurementType extends Model
{
    use HasFactory;

    protected $table = 'bs_measurement_types';

    protected $fillable = [
        'name',
    ];

    public function bsRecords()
    {
        return $this->hasMany(BsRecord::class, 'measurement_type_id');
    }

    public function bsRanges()
    {
        return $this->hasMany(BsRange::class, 'measurement_type_id');
    }
}