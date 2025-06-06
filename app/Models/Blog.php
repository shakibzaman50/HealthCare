<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tags',
        'is_active',
        'thumbnail',
        'content'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', config('basic.status.active'));
    }
}
