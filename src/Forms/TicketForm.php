<?php

namespace FriendsOfBotble\Ticksify\Forms;

use Botble\Base\Forms\FormAbstract;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicketForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Ticket::class);
    }
}
