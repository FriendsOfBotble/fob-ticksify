<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers\Fronts;

use Botble\Base\Http\Controllers\BaseController;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use FriendsOfBotble\Ticksify\Forms\Fronts\TicketForm;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketRequest;
use FriendsOfBotble\Ticksify\Support\Helper;

class TicketController extends BaseController
{
    public function index()
    {
        SeoHelper::setTitle(__('Tickets'));

        $tickets = Helper::getAuthUser()
            ->tickets()
            ->paginate();

        return Theme::scope(
            'fob-ticksify.tickets.index',
            compact('tickets'),
            'plugins/fob-ticksify::themes.tickets.index'
        )->render();
    }

    public function create()
    {
        $form = TicketForm::create();

        return Theme::scope(
            'fob-ticksify.tickets.create',
            compact('form'),
            'plugins/fob-ticksify::themes.tickets.create'
        )->render();
    }

    public function store(TicketRequest $request)
    {
        $ticketForm = TicketForm::create()->setRequest($request)->onlyValidatedData();
        $ticketForm->saving(function (TicketForm $ticketForm) {
            $model = $ticketForm->getModel();
            $user = Helper::getAuthUser();

            $model->fill([
                ...$ticketForm->getRequestData(),
                'sender_type' => $user::class,
                'sender_id' => $user->getKey(),
            ]);

            $model->save();
        });

        return $this
            ->httpResponse()
            ->setNextRoute(
                'fob-ticksify.public.tickets.show',
                $ticketForm->getModel()->getKey()
            )
            ->setMessage(__('Your ticket has been created successfully.'));
    }

    public function show(string $ticket)
    {
        $ticket = Helper::getAuthUser()
            ->tickets()
            ->findOrFail($ticket);

        return Theme::scope(
            'fob-ticksify.tickets.show',
            compact('ticket'),
            'plugins/fob-ticksify::themes.tickets.show'
        )->render();
    }
}
