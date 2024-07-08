<?php

namespace FriendsOfBotble\Ticksify\Forms;

use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FormAbstract;
use Botble\Base\Forms\MetaBox;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use FriendsOfBotble\Ticksify\Http\Requests\TicketRequest;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicketForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Ticket::class)
            ->setValidatorClass(TicketRequest::class)
            ->setBreakFieldPoint('status')
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make()
                    ->choices(TicketStatus::labels()),
            )
            ->addMetaBox(
                MetaBox::make('Information')
                    ->title(trans('plugins/fob-ticksify::ticksify.tickets.name'))
                    ->content('hehe')
            )
            ->add(
                'priority',
                SelectField::class,
                StatusFieldOption::make()
                    ->choices(TicketPriority::labels()),
            )
            ->add(
                'is_locked',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/fob-ticksify::ticksify.locked'))
            )
            ->add(
                'is_resolved',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/fob-ticksify::ticksify.resolved'))
            );
    }
}
