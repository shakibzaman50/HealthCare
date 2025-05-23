<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BsRecord extends Model
{
    use HasFactory;

    protected $table = 'bs_records';

    protected $fillable = [
        'profile_id',
        'sugar_schedule_id',
        'sugar_unit_id',
        'value',
        'status',
        'measurement_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'measurement_at' => 'datetime',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function sugarSchedule(): BelongsTo
    {
        return $this->belongsTo(SugarSchedule::class);
    }

    public function sugarUnit(): BelongsTo
    {
        return $this->belongsTo(SugarUnit::class);
    }
}