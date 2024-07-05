<?php

namespace FriendsOfBotble\Ticksify\Enums;

use Botble\Base\Supports\Enum;

class TicketPriority extends Enum
{
    public const LOW = 'low';

    public const MEDIUM = 'medium';

    public const HIGH = 'high';

    public const CRITICAL = 'critical';
}
