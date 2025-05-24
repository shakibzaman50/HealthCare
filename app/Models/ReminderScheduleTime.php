<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReminderScheduleTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'time',
        'label',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time' => 'datetime:H:i'
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(ReminderSchedule::class, 'schedule_id');
    }

    public function reminder(): HasMany
    {
        return $this->hasMany(MedicineReminder::class, 'reminder_id');
    }
}