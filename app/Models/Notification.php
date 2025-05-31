<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'allow_all_notification',
        'notification_snozing',
        'notification_dot_on_app',
        'reminder_notifications'
    ];

    protected $casts = [
        'allow_all_notification' => 'boolean',
        'notification_snozing' => 'boolean',
        'notification_dot_on_app' => 'boolean',
        'reminder_notifications' => 'boolean'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
} 