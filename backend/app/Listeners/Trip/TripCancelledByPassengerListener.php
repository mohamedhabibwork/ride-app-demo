<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripCancelledByPassengerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripCancelledByPassengerListener
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
    public function handle(TripCancelledByPassengerEvent $event): void
    {
        //
    }
}
