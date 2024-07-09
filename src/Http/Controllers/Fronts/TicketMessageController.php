<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers\Fronts;

use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\Ticksify\Actions\StoreTicketMessageAction;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;
use FriendsOfBotble\Ticksify\Support\Helper;

class TicketMessageController extends BaseController
{
    public function store(
        string $ticket,
        TicketMessageRequest $request,
        StoreTicketMessageAction $storeTicketMessageAction
    ) {
        /** @var Ticket $ticket */
        $ticket = Helper::getAuthUser()
            ->tickets()
            ->findOrFail($ticket);

        if ($ticket->is_locked) {
            return $this->httpResponse()
                ->setMessage(__('This ticket is locked.'))
                ->setNextRoute('fob-ticksify.public.tickets.show', $ticket->getKey());
        }

        $storeTicketMessageAction(Helper::getAuthUser(), $ticket, $request);

        return $this
            ->httpResponse()
            ->setNextRoute('fob-ticksify.public.tickets.show', $ticket->getKey())
            ->setMessage(__('Your message has been sent successfully.'));
    }
}
