<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripDriverArrivedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripDriverArrivedListener
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
    public function handle(TripDriverArrivedEvent $event): void
    {
        //
    }
}
