<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class UserLoggedInNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $code){}

    public function via($notifiable): array
    {
        return [VonageSmsChannel::class];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage('text with '.$this->code.' length'))
            ->clientReference(
                (string) $notifiable->id
            );
    }
}
