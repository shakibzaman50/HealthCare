<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicineFrequencyTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'frequency_id',
        'time',
    ];

    protected $casts = [
        // 'time' => 'time',
    ];

    public function frequency(): BelongsTo
    {
        return $this->belongsTo(MedicineFrequency::class, 'frequency_id');
    }
} 