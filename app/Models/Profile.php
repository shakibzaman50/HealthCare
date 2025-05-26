<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'age',
        'weight',
        'weight_unit',
        'height_unit',
        'height',
        'birth_year',
        'bmi',
        'gender',

    ];
    protected $appends = ['avatar_url'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('images/default-avatar.png'); // fallback image
    }

    public function assessment()
    {
        return $this->hasOne(ProfileAssessment::class);
    }

    public function weightUnit()
    {
        return $this->belongsTo(WeightUnit::class, 'weight_unit', 'id');
    }
    public function heightUnit()
    {
        return $this->belongsTo(HeightUnit::class, 'height_unit', 'id');
    }

    public function bloodPressures()
    {
        return $this->hasMany(BloodPressure::class, 'profile_id', 'id')->with('unit');
    }

    public function bloodOxygens()
    {
        return $this->hasMany(BloodOxygen::class, 'profile_id', 'id');
    }

    public function heartRates()
    {
        return $this->hasMany(HeartRate::class, 'profile_id', 'id')->with('unit');
    }

    public function hydrationReminders()
    {
        return $this->hasMany(HydrationReminder::class, 'profile_id', 'id')->with('unit');
    }
}