<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicineReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'end_date',
        'is_repeat',
        'till_turn_off'
    ];

    protected $casts = [
        'is_repeat' => 'boolean',
        'till_turn_off' => 'boolean',
        'end_date' => 'date'
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ReminderSchedule::class, 'reminder_id');
    }

    public function scheduleTimes(): HasMany
    {
        return $this->hasMany(ReminderScheduleTime::class, 'reminder_id');
    }
}