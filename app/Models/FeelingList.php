<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeelingList extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
        'emoji'
    ];

    protected $appends = ['emoji_url'];
    public function scopeActive($query)
    {
        return $query->where('is_active', config('basic.status.active'));
    }
    public function getEmojiUrlAttribute()
    {
        return $this->emoji
            ? asset('storage/' . $this->emoji)
            : asset('images/default-avatar.png'); // fallback image
    }
}
