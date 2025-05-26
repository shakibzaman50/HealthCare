<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodPressure extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'unit_id',
        'systolic',
        'diastolic',
        'status',
        'measured_at'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id')->select('id', 'user_id', 'name');
    }

    public function unit(){
        return $this->belongsTo(BpUnit::class,'unit_id')->select('id','name');
    }
}
