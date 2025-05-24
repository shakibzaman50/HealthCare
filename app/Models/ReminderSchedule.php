<?php

namespace App\Models;

use App\Enums\ScheduleEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReminderSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'reminder_id',
        'schedule_type',
        'how_many_times'
    ];

    protected $casts = [
        'schedule_type' => ScheduleEnums::class,
        'how_many_times' => 'integer'
    ];

    public function reminder(): BelongsTo
    {
        return $this->belongsTo(MedicineReminder::class, 'reminder_id');
    }

    public function scheduleTimes(): HasMany
    {
        return $this->hasMany(ReminderScheduleTime::class, 'schedule_id');
    }
}