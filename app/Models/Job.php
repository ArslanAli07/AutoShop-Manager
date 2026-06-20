<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_number',
        'customer_id',
        'car_id',
        'status',
        'payment_status',
        'amount_paid',
        'mileage_in',
        'mileage_out',
        'date_in',
        'date_out',
        'notes',
        'warranty_notes',
        'next_service_date',
        'next_service_mileage'
    ];

    protected $casts = [
        'date_in' => 'date',
        'date_out' => 'date',
        'next_service_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class)->withTrashed();
    }

    public function services(): HasMany
    {
        return $this->hasMany(JobService::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(JobPart::class);
    }
}
