<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\Ticksify\Actions\StoreTicketMessageAction;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicketMessageController extends BaseController
{
    public function store(
        Ticket $ticket,
        TicketMessageRequest $request,
        StoreTicketMessageAction $storeTicketMessageAction
    ) {
        $storeTicketMessageAction($request->user(), $ticket, $request);

        return $this
            ->httpResponse()
            ->setNextRoute('fob-ticksify.tickets.show', $ticket->getKey())
            ->setMessage(__('Your message has been sent successfully.'));
    }
}
