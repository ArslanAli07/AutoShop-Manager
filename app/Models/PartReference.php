<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartReference extends Model
{
    use SoftDeletes;
    protected $table = 'parts_reference';

    protected $fillable = [
        'name',
        'part_number',
        'default_price',
        'needs_reorder',
    ];

    protected $casts = [
        'default_price' => 'decimal:2',
        'needs_reorder' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
