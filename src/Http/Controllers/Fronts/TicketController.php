<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers\Fronts;

use Botble\Base\Http\Controllers\BaseController;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use FriendsOfBotble\Ticksify\Forms\Fronts\MessageForm;
use FriendsOfBotble\Ticksify\Forms\Fronts\TicketForm;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;
use FriendsOfBotble\Ticksify\Support\Helper;

class TicketController extends BaseController
{
    public function index()
    {
        SeoHelper::setTitle(__('Tickets'));
        Theme::breadcrumb()->add(__('Tickets'), route('fob-ticksify.public.tickets.index'));
        Theme::asset()->add('ticksify', 'vendor/core/plugins/fob-ticksify/css/front-ticksify.css');

        $tickets = Helper::getAuthUser()
            ->tickets()
            ->paginate();

        $user = Helper::getAuthUser();

        $stats = Ticket::query()
            ->where('sender_type', $user::class)
            ->where('sender_id', $user->getKey())
            ->withStatistics()
            ->first();

        return Theme::scope(
            'fob-ticksify.tickets.index',
            compact('tickets', 'stats'),
            'plugins/fob-ticksify::themes.tickets.index'
        )->render();
    }

    public function show(string $ticket)
    {
        /** @var Ticket $ticket */
        $ticket = Helper::getAuthUser()
            ->tickets()
            ->findOrFail($ticket);

        $title = __('Ticket #:ticket - :title', [
            'ticket' => $ticket->getKey(),
            'title' => $ticket->title,
        ]);

        SeoHelper::setTitle($title);
        Theme::breadcrumb()
            ->add(__('Tickets'), route('fob-ticksify.public.tickets.index'))
            ->add($title);

        $messages = $ticket->messages()
            ->wherePublished()
            ->with('sender')
            ->latest()
            ->paginate(10);

        $form = MessageForm::create()
            ->setUrl(route('fob-ticksify.public.tickets.messages.store', $ticket));

        return Theme::scope(
            'fob-ticksify.tickets.show',
            compact('ticket', 'messages', 'form'),
            'plugins/fob-ticksify::themes.tickets.show'
        )->render();
    }

    public function create()
    {
        SeoHelper::setTitle(__('Create Ticket'));
        Theme::breadcrumb()
            ->add(__('Tickets'), route('fob-ticksify.public.tickets.index'))
            ->add(__('Create Ticket'));
        Theme::asset()->add('ticksify', 'vendor/core/plugins/fob-ticksify/css/front-ticksify.css');

        $form = TicketForm::create();

        return Theme::scope(
            'fob-ticksify.tickets.create',
            compact('form'),
            'plugins/fob-ticksify::themes.tickets.create'
        )->render();
    }

    public function store(TicketRequest $request)
    {
        $form = TicketForm::create()->setRequest($request)->onlyValidatedData();
        $form->saving(function (TicketForm $form) {
            $model = $form->getModel();
            $user = Helper::getAuthUser();

            $model->fill([
                ...$form->getRequestData(),
                'sender_type' => $user::class,
                'sender_id' => $user->getKey(),
                'status' => TicketStatus::OPEN,
            ]);

            $model->save();
        });

        return $this
            ->httpResponse()
            ->setNextRoute(
                'fob-ticksify.public.tickets.show',
                $form->getModel()->getKey()
            )
            ->setMessage(__('Your ticket has been created successfully.'));
    }
}
