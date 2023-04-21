<?php

namespace App\Events\Trip;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Broadcasting\Channel;

trait TripEvent
{

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Trip $trip,
        public User $driver,
    )
    {
        $this->broadcastVia('pusher');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {

        return [
            new Channel(sprintf('trips.%s', $this->trip->id)),
            new Channel(sprintf('passengers.%s', $this->trip->user_id)),
            new Channel(sprintf('drivers.%s', $this->trip->driver_id)),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'trip' => [
                'id' => $this->trip->id,
                'user_id' => $this->trip->user_id,
                'origin' => $this->trip->origin,
                'destination' => $this->trip->destination,
                'user_location' => $this->trip->user_location,
                'driver_location' => $this->trip->driver_location,
                'destination_name' => $this->trip->destination_name,
            ],
            'driver' => $this->trip->driver_id ? $this->driver->only([
                'id', 'name'
            ]) : null,
            'passenger' => $this->trip->user->only([
                'id', 'name'
            ]),
        ];
    }
}
