<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers\Fronts;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Controllers\BaseController;
use FriendsOfBotble\Ticksify\Forms\MessageForm;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;
use FriendsOfBotble\Ticksify\Support\Helper;

class TicketMessageController extends BaseController
{
    public function store(Ticket $ticket, TicketMessageRequest $request)
    {
        MessageForm::create()
            ->setRequest($request)
            ->onlyValidatedData()
            ->saving(function (MessageForm $form) use ($ticket) {
                $user = Helper::getAuthUser();

                $ticket->messages()->create([
                    ...$form->getRequestData(),
                    'status' => BaseStatusEnum::PUBLISHED,
                    'sender_type' => $user::class,
                    'sender_id' => $user->getKey(),
                ]);
            });

        return $this
            ->httpResponse()
            ->setNextRoute('fob-ticksify.public.tickets.show', $ticket->getKey())
            ->setMessage(__('Your message has been sent successfully.'));
    }
}
