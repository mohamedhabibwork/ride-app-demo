<?php

namespace App\Events\Trip;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TripCreatedEvent  implements \Illuminate\Contracts\Broadcasting\ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    use TripEvent, InteractsWithBroadcasting;

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel(sprintf('trips.%s', $this->trip->id)),
            new Channel(sprintf('passenger.%s', $this->trip->user_id)),
            new Channel('drivers'),
            new Channel("drivers.{$this->trip->driver_id}"),
        ];
    }

}
