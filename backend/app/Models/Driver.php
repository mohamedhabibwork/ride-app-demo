<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'year',
        'make',
        'model',
        'color',
        'license_plate',
        'status',
        'balance',
    ];

    protected $casts = [
        'status' => 'boolean',
        'balance' => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @return HasMany
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }
}
