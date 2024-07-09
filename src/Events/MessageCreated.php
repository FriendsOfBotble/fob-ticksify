<?php

namespace FriendsOfBotble\Ticksify\Events;

use FriendsOfBotble\Ticksify\Models\Message;
use Illuminate\Foundation\Events\Dispatchable;

class MessageCreated
{
    use Dispatchable;

    public function __construct(
        public Message $message
    ) {
    }
}
