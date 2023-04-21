<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripStartedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripStartedListener
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
    public function handle(TripStartedEvent $event): void
    {
        //
    }
}
