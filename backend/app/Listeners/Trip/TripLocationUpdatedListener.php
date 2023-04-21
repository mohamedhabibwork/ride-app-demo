<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripLocationUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripLocationUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TripLocationUpdatedEvent $event): void
    {
        //
    }
}
