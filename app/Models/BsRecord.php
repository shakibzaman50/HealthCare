<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BsRecord extends Model
{
    use HasFactory;

    protected $table = 'bs_records';

    protected $fillable = [
        'profile_id',
        'measurement_type_id',
        'unit_id',
        'value',
        'measurement_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'measurement_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function measurementType()
    {
        return $this->belongsTo(BsMeasurementType::class, 'measurement_type_id');
    }

    public function unit()
    {
        return $this->belongsTo(SugarUnit::class, 'unit_id');
    }
}