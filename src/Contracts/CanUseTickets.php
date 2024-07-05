<?php

namespace FriendsOfBotble\Ticksify\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface CanUseTickets
{
    public function tickets(): MorphMany;
}
