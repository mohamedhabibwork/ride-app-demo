<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TripPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function create(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Trip $trip): bool
    {
        return true;
        return $user->id === $trip->user_id || $user->id === $trip->driver_id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Trip $trip): bool
    {
        return $user->id === $trip->user_id || $user->id === $trip->driver_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Trip $trip): bool
    {
        return $user->id === $trip->user_id || $user->id === $trip->driver_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Trip $trip): Response
    {
        return Response::deny('You can not restore a trip');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Trip $trip): Response
    {
        return Response::deny('You can not force delete a trip');
    }
}
