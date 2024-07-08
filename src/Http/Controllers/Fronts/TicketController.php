<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers\Fronts;

use Botble\Base\Http\Controllers\BaseController;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use FriendsOfBotble\Ticksify\Forms\Fronts\TicketForm;
use FriendsOfBotble\Ticksify\Forms\MessageForm;
use FriendsOfBotble\Ticksify\Http\Requests\Fronts\TicketRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;
use FriendsOfBotble\Ticksify\Support\Helper;

class TicketController extends BaseController
{
    public function index()
    {
        SeoHelper::setTitle(__('Tickets'));
        Theme::breadcrumb()->add(__('Tickets'), route('fob-ticksify.public.tickets.index'));
        Theme::asset()->add('ticksify', 'vendor/core/plugins/fob-ticksify/css/ticksify.css');

        $tickets = Helper::getAuthUser()
            ->tickets()
            ->paginate();

        $stats = Helper::getAuthUser()->tickets()
            ->toBase()
            ->selectRaw('count(*) as total')
            ->selectRaw('count(if(status = "open", 1, null)) as open')
            ->selectRaw('count(if(status = "in_progress", 1, null)) as in_progress')
            ->selectRaw('count(if(status = "closed", 1, null)) as closed')
            ->selectRaw('count(if(status = "on_hold", 1, null)) as on_hold')
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
        Theme::asset()->add('ticksify', 'vendor/core/plugins/fob-ticksify/css/ticksify.css');

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
