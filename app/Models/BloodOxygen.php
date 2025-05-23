<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodOxygen extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'oxygen_level',
        'measured_at'
    ];
}
