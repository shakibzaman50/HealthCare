<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicineType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function getStatusBadgeAttribute(): string
    {
        $statusConfig = config('basic.status');
        $isActive     = $this->is_active == $statusConfig['active'];

        $class = $isActive ? 'success' : 'danger';
        $text  = $isActive ? 'Active' : 'Inactive';

        return "<div class='badge badge-{$class}'>{$text}</div>";
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', config('basic.status.active'));
    }
}
