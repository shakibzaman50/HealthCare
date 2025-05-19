<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BsRange extends Model
{
    use HasFactory;

    protected $table = 'bs_ranges';

    protected $fillable = [
        'sugar_unit_id',
        'measurement_type_id',
        'category',
        'min_value',
        'max_value',
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected $casts = [
        'id' => 'string',
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
    ];

    public function unit()
    {
        return $this->belongsTo(SugarUnit::class, 'sugar_unit_id');
    }

    public function measurementType()
    {
        return $this->belongsTo(BsMeasurementType::class, 'measurement_type_id');
    }
}