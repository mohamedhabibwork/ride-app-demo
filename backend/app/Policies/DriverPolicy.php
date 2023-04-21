<?php

namespace App\Policies;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DriverPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Driver $driver): Response
    {
        return ($user->id === $driver->user_id || $user->trips()->whereBelongsTo($driver)->exists() || $this->viewAny($user))
            ? Response::allow()
            : Response::deny('You are not allowed to view this driver.');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->email, [
            'admin@app.com',
            'habib@app.com',
            'test@app.com',
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Driver $driver): bool
    {
        return $user->id === $driver->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Driver $driver): bool
    {
        return $user->id === $driver->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Driver $driver): Response
    {
        return Response::deny('You are not allowed to restore this driver.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Driver $driver): Response
    {
        return Response::deny('You are not allowed to permanently delete this driver.');
    }
}
