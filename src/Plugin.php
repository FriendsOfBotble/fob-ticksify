<?php

namespace FriendsOfBotble\Ticksify;

use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        Schema::dropIfExists('fob_ticket_messages');
        Schema::dropIfExists('fob_ticket_category');
        Schema::dropIfExists('fob_tickets');
        Schema::dropIfExists('fob_ticket_categories');
    }
}
