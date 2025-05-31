<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'heart_beat',
        'blood_presure',
        'blood_sugar',
        'water_intake',
        'habit_tracker',
        'medication'
    ];

    protected $casts = [
        'heart_beat' => 'boolean',
        'blood_presure' => 'boolean',
        'blood_sugar' => 'boolean',
        'water_intake' => 'boolean',
        'habit_tracker' => 'boolean',
        'medication' => 'boolean'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
