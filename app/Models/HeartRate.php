<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeartRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'unit_id',
        'heart_rate',
        'measured_at'
    ];

    public function unit(){
        return $this->belongsTo(HeartRateUnit::class,'unit_id')->select('id','name');
    }
}
