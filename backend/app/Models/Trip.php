<?php

namespace App\Models;

use App\Casts\PointCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Expression;
use Str;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'user_id',
        'is_started',
        'is_arrived',
        'is_complete',
        'origin',
        'destination',
        'driver_location',
        'user_location',
        'destination_name',
        'distance',
        'cost',
        'accepted_at',
        'started_at',
        'arrived_at',
        'complete_at',
        'start_code',
        'is_cancelled',
        'cancelled_at',
        'channel'
    ];

    protected $casts = [
        'is_started' => 'boolean',
        'is_arrived' => 'boolean',
        'is_complete' => 'boolean',
        'is_cancelled' => 'boolean',
        'distance' => 'float',
        'cost' => 'float',
        'accepted_at' => 'datetime',
        'started_at' => 'datetime',
        'arrived_at' => 'datetime',
        'complete_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'channel' => 'string',
        'origin' => PointCast::class,
        'destination' => PointCast::class,
        'driver_location' => PointCast::class,
        'user_location' => PointCast::class,
    ];

    protected $hidden = [
        'start_code',
        'channel',
//        'origin',
//        'destination',
//        'driver_location',
//        'user_location',
    ];
    protected static function booted()
    {
        parent::booted();

        static::creating(function ($trip) {
            $trip->start_code ??= rand(100000, 999999);
            $trip->channel ??= Str::uuid();
        });
    }

    /**
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
