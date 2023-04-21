<?php

namespace App\Events\Trip;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TripCancelledByDriverEvent  implements \Illuminate\Contracts\Broadcasting\ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels,TripEvent;
    use TripEvent,\Illuminate\Broadcasting\InteractsWithBroadcasting;

}
