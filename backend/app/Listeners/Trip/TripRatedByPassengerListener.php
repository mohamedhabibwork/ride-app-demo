<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripRatedByPassengerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripRatedByPassengerListener
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
    public function handle(TripRatedByPassengerEvent $event): void
    {
        //
    }
}
