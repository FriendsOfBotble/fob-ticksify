<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
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

    public function edit(Ticket $ticket)
    {
        $this->pageTitle($ticket->title);

        return TicketForm::createFromModel($ticket)->renderForm();
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
                'fob-ticksify.tickets.edit',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Ticket $ticket)
    {
        return DeleteResourceAction::make($ticket);
    }
}
