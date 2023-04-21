<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripRatedByDriverEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripRatedByDriverListener
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
    public function handle(TripRatedByDriverEvent $event): void
    {
        //
    }
}
