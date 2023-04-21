<?php

namespace App\Events\Trip;

use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TripAcceptEvent  implements \Illuminate\Contracts\Broadcasting\ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels,TripEvent, InteractsWithBroadcasting;
}
