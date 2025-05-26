<?php

namespace App\Models;

use App\Enums\ScheduleEnums;
use Database\Factories\MedicineFrequencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicineFrequency extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'end_date',
        'frequency_type',
        'is_repeat',
        'till_turn_off',
    ];

    protected $casts = [
        'end_date' => 'date',
        'is_repeat' => 'boolean',
        'till_turn_off' => 'boolean',
        'frequency_type' => ScheduleEnums::class,
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }

    public function times(): HasMany
    {
        return $this->hasMany(MedicineFrequencyTime::class, 'frequency_id');
    }
} 