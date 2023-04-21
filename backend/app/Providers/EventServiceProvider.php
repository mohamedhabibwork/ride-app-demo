<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\Trip\TripAcceptEvent::class => [
            \App\Listeners\Trip\TripAcceptListener::class,
        ],
        \App\Events\Trip\TripCreatedEvent::class => [
            \App\Listeners\Trip\TripCreatedListener::class,
        ],
        \App\Events\User\UserLoggedInEvent::class => [
            \App\Listeners\User\UserLoggedInListener::class,
        ],
        \App\Events\Trip\TripDriverArrivedEvent::class => [
            \App\Listeners\Trip\TripDriverArrivedListener::class,
        ],
        \App\Events\Trip\TripStartedEvent::class => [
            \App\Listeners\Trip\TripStartedListener::class,
        ],

        \App\Events\Trip\TripCancelledByPassengerEvent::class => [
            \App\Listeners\Trip\TripCancelledByPassengerListener::class,
        ],

        \App\Events\Trip\TripCancelledByDriverEvent::class => [
            \App\Listeners\Trip\TripCancelledByDriverListener::class,
        ],

        \App\Events\Trip\TripEndedEvent::class => [
            \App\Listeners\Trip\TripEndedListener::class,
        ],

        \App\Events\Trip\TripLocationUpdatedEvent::class => [
            \App\Listeners\Trip\TripLocationUpdatedListener::class,
        ],

        \App\Events\Trip\TripRatedByPassengerEvent::class => [
            \App\Listeners\Trip\TripRatedByPassengerListener::class,
        ],

        \App\Events\Trip\TripRatedByDriverEvent::class => [
            \App\Listeners\Trip\TripRatedByDriverListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
