<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobService extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'service_preset_id', 'description', 'labor_cost'];

    protected $casts = [
        'labor_cost' => 'decimal:2',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function servicePreset(): BelongsTo
    {
        return $this->belongsTo(ServicePreset::class);
    }
}
