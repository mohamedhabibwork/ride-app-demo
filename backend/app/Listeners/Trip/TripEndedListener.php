<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripEndedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripEndedListener
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
    public function handle(TripEndedEvent $event): void
    {
        //
    }
}
