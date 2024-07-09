<?php

namespace FriendsOfBotble\Ticksify\Actions;

use Botble\Base\Enums\BaseStatusEnum;
use FriendsOfBotble\Ticksify\Events\MessageCreated;
use FriendsOfBotble\Ticksify\Forms\Fronts\MessageForm;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketMessageRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;
use Illuminate\Contracts\Auth\Authenticatable;

class StoreTicketMessageAction
{
    public function __invoke(
        Authenticatable $actor,
        Ticket $ticket,
        TicketMessageRequest $request
    ): void {
        MessageForm::create()
            ->setRequest($request)
            ->onlyValidatedData()
            ->saving(function (MessageForm $form) use ($ticket, $actor) {
                $message = $ticket->messages()->create([
                    ...$form->getRequestData(),
                    'status' => BaseStatusEnum::PUBLISHED,
                    'sender_type' => $actor::class,
                    'sender_id' => $actor->getKey(),
                ]);

                MessageCreated::dispatch($message);
            });
    }
}
