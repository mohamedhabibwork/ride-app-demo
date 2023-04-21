<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Notification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'login_code',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'login_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'login_code' => 'integer',
    ];

    /**
     * @return Attribute
     */
    public function name(): Attribute
    {
        return Attribute::get(fn() => "$this->first_name $this->last_name");
    }

    /**
     * @return HasMany
     */
    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class, 'user_id');
    }

    /**
     * @return bool
     */
    public function isDriver(): bool
    {
        return $this->driver()->exists();
    }

    /**
     * @return HasOne
     */
    public function driver(): hasOne
    {
        return $this->hasOne(
            Driver::class,
            'user_id',
            'id'
        )->latest();
    }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return "users.{$this->id}";
    }

    /**
     * Route notifications for the Vonage channel.
     */
    public function routeNotificationForVonage($notification): string
    {
        return "+2{$this->phone}";
    }
}
