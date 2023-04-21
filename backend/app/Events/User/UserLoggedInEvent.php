<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedInEvent  implements \Illuminate\Contracts\Broadcasting\ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function __construct(public User $user)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array{Channel}
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('users.' . $this->user->id)
        ];
    }
}
