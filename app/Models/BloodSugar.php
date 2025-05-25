<?php

namespace App\Models;

use App\Observers\BloodSugarObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(BloodSugarObserver::class)]
class BloodSugar extends Model
{
    use HasFactory;
    

    protected $table = 'blood_sugars';
    
    protected $fillable = [
        'profile_id',
        'sugar_schedule_id',
        'sugar_unit_id',
        'value',
        'status',
        'measured_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'measured_at' => 'datetime',
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