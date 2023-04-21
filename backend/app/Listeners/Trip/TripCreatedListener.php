<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripCreatedListener
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
    public function handle(TripCreatedEvent $event): void
    {
        //
    }
}
