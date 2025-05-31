<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'habit_task_id',
        'type',
        'duration',
        'end_date',
        'description',
        'color',
        'is_repeat',
        'till_turn_off'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id')->select('id','user_id', 'name');
    }

    public function habitTask()
    {
        return $this->belongsTo(HabitTask::class, 'habit_task_id')->select('id', 'name', 'habit_list_id');
    }

    public function frequencies()
    {
        return $this->hasMany(HabitFrequency::class,'habit_schedule_id')->select('id','habit_schedule_id','day','how_many_times');
    }
}
