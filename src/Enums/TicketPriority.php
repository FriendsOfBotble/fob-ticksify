<?php

namespace FriendsOfBotble\Ticksify\Enums;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

class TicketPriority extends Enum
{
    public const LOW = 'low';

    public const MEDIUM = 'medium';

    public const HIGH = 'high';

    public const CRITICAL = 'critical';

    protected static $langPath = 'plugins/fob-ticksify::ticksify.enums.priorities';

    public function toHtml(): HtmlString|string
    {
        $color = match ($this->value) {
            self::LOW => 'info',
            self::MEDIUM => 'warning',
            self::HIGH, self::CRITICAL => 'danger',
            default => 'secondary',
        };

        return BaseHelper::renderBadge($this->label(), $color);
    }
}
