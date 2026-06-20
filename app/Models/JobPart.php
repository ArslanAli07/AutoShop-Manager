<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobPart extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'parts_reference_id', 'part_name', 'part_number', 'quantity', 'unit_price', 'total_price'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function partsReference(): BelongsTo
    {
        return $this->belongsTo(PartReference::class);
    }
}
