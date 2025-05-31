<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'path',
        'type'
    ];
}
