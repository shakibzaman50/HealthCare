<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HabitTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'habit_list_id',
        'profile_id',
        'name',
        'is_active',
        'icon'
    ];

    public function habitList()
    {
        return $this->belongsTo(HabitList::class, 'habit_list_id')->select('id', 'name');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id')->select('id','user_id', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', config('basic.status.active'));
    }
}
