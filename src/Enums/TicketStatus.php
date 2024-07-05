<?php

namespace FriendsOfBotble\Ticksify\Enums;

use Botble\Base\Supports\Enum;

class TicketStatus extends Enum
{
    public const OPEN = 'open';

    public const CLOSED = 'closed';

    public const ARCHIVED = 'archived';
}
