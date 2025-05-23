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
        'measured_at'
    ];

    public function unit(){
        return $this->belongsTo(BpUnit::class,'unit_id')->select('id','name');
    }
}
