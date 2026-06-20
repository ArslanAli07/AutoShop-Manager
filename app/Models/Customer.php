<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'phone', 'address', 'notes'];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function jobs(): HasManyThrough
    {
        return $this->hasManyThrough(Job::class, Car::class);
    }
}
