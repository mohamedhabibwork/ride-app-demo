<?php

namespace App\Listeners\Trip;

use App\Events\Trip\TripAcceptEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TripAcceptListener
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
    public function handle(TripAcceptEvent $event): void
    {
        //
    }
}
