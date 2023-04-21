<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripCancelledByDriverEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripCancelledByDriverListener
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
    public function handle(TripCancelledByDriverEvent $event): void
    {
        //
    }
}
