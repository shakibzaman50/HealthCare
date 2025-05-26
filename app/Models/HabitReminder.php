<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'habit_frequency_id',
        'reminder_time',
        'is_active'
    ];

    public function habitTask()
    {
        return $this->belongsTo(HabitList::class, 'habit_frequency_id')->select('id', 'name', 'habit_schedule_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', config('basic.status.active'));
    }
}
