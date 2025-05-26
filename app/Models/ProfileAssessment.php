<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'live_active_lifestyle',
        'insulin_resistance',
        'hypertension',
        'activity_level_id',
        'hydration_goal',
        'physical_condition_id',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function activityLevel()
    {
        return $this->belongsTo(ActivityLevel::class);
    }

    public function physicalCondition()
    {
        return $this->belongsTo(PhysicalCondition::class);
    }
}