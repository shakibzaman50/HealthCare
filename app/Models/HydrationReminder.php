<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HydrationReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'unit_id',
        'amount',
        'drink_at'
    ];

    public function unit(){
        return $this->belongsTo(WaterUnit::class,'unit_id')->select('id','name');
    }
}
