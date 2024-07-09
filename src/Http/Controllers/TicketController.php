<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use FriendsOfBotble\Ticksify\Forms\Fronts\MessageForm;
use FriendsOfBotble\Ticksify\Forms\TicketForm;
use FriendsOfBotble\Ticksify\Http\Requests\TicketRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;
use FriendsOfBotble\Ticksify\Tables\TicketTable;

class TicketController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/fob-ticksify::ticksify.name'))
            ->add(
                trans('plugins/fob-ticksify::ticksify.tickets.name'),
                route('fob-ticksify.tickets.index')
            );
    }

    public function index(TicketTable $ticketTable)
    {
        $this->pageTitle(trans('plugins/fob-ticksify::ticksify.tickets.name'));

        return $ticketTable->renderTable();
    }

    public function show(Ticket $ticket)
    {
        $this->pageTitle($ticket->title);

        Assets::addStylesDirectly('vendor/core/plugins/fob-ticksify/css/ticksify.css');

        $messages = $ticket->messages()
            ->latest()
            ->with('sender')
            ->paginate();

        $ticketForm = TicketForm::createFromModel($ticket);
        $messageForm = MessageForm::create()
           ->setUrl(route('fob-ticksify.tickets.messages.store', $ticket));

        return view(
            'plugins/fob-ticksify::tickets.show',
            compact('ticket', 'messageForm', 'ticketForm', 'messages')
        );
    }

    public function update(Ticket $ticket, TicketRequest $request)
    {
        $form = TicketForm::createFromModel($ticket)
            ->setRequest($request)
            ->onlyValidatedData();

        $form->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('fob-ticksify.tickets.index')
            ->setNextRoute(
                'fob-ticksify.tickets.show',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Ticket $ticket)
    {
        return DeleteResourceAction::make($ticket);
    }
}
