<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('trips.{trip}', function ($user,\App\Models\Trip $trip) {
    return (int) $user->id === (int) $trip->user_id || (int) $user->id === (int) $trip->driver_id;
});

Broadcast::channel('passenger.{passenger}', function ($user,\App\Models\User $passenger) {
    return (int) $user->id === (int) $passenger->id;
});

Broadcast::channel('drivers', function ($user) {
    return $user;
});

Broadcast::channel('drivers.{driver}', function ($user,\App\Models\Driver $driver) {
    return $user->id === $driver->user_id;
});

