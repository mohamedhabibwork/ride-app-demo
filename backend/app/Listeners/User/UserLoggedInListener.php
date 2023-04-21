<?php

namespace App\Listeners\User;

use App\Events\User\UserLoggedInEvent;
use App\Notifications\User\UserLoggedInNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedInListener
{
    /**
     * Handle the event.
     */
    public function handle(UserLoggedInEvent $event): void
    {
        $code = mt_rand(1000, 9999);

        $event->user->update([
            'login_code' => $code,
        ]);

        $event->user->notify(new UserLoggedInNotification($code));

    }
}
