<?php

namespace FriendsOfBotble\Ticksify\Support;

use FriendsOfBotble\Ticksify\Contracts\CanUseTickets;
use Illuminate\Contracts\Auth\Authenticatable;

class Helper
{
    public static function getAuthGuard(): string
    {
        return match (true) {
            is_plugin_active('ecommerce') => 'customer',
            is_plugin_active('real-estate')
            || is_plugin_active('job-board')
            || is_plugin_active('hotel') => 'account',
            default => null,
        };
    }

    /**
     * @return (Authenticatable&CanUseTickets)|null
     */
    public static function getAuthUser(): ?Authenticatable
    {
        return auth(self::getAuthGuard())->user();
    }
}
