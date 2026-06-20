<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePreset extends Model
{
    use SoftDeletes;
    protected $table = 'service_presets';

    protected $fillable = [
        'name',
        'category',
        'default_labor_cost',
    ];

    protected $casts = [
        'default_labor_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
