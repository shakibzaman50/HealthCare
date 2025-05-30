<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitFrequency extends Model
{
    use HasFactory;

    protected $fillable = [
        'habit_schedule_id',
        'day',
        'how_many_times'
    ];

    public function habitSchedule()
    {
        return $this->belongsTo(HabitList::class, 'habit_schedule_id')->select('id', 'name', 'habit_task_id');
    }

    public function reminders()
    {
        return $this->hasMany(HabitReminder::class, 'habit_frequency_id')->select('id', 'habit_frequency_id', 'reminder_time', 'is_active');
    }
}
