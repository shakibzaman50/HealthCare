<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'medicine_type_id',
        'medicine_unit_id',
        'name',
        'strength',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'strength' => 'integer',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function medicineType(): BelongsTo
    {
        return $this->belongsTo(MedicineType::class);
    }

    public function medicineUnit(): BelongsTo
    {
        return $this->belongsTo(MedicineUnit::class);
    }

    public function frequencies(): HasMany
    {
        return $this->hasMany(MedicineFrequency::class);
    }
} 