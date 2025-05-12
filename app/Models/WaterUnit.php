<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaterUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
    ];

    public function getStatusBadgeAttribute(): string
    {
        $statusConfig = config('basic.status');
        $isActive     = $this->status == $statusConfig['active'];

        $class = $isActive ? 'success' : 'danger';
        $text  = $isActive ? 'Active' : 'Inactive';

        return "<div class='badge badge-{$class}'>{$text}</div>";
    }

    public function scopeActive($query)
    {
        return $query->where('status', config('basic.status.active'));
    }
}
