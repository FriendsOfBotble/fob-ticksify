<?php

namespace FriendsOfBotble\Ticksify\Forms;

use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
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
            ->contentOnly()
            ->setValidatorClass(TicketRequest::class)
            ->setFormOption('id', 'ticket-form')
            ->setUrl(route('fob-ticksify.tickets.update', $this->getModel()))
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/fob-ticksify::ticksify.title'))
            )
            ->add(
                'content',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('plugins/fob-ticksify::ticksify.content'))
                    ->rows(5)
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make()
                    ->choices(TicketStatus::labels()),
            )
            ->add(
                'priority',
                SelectField::class,
                StatusFieldOption::make()
                    ->label(trans('plugins/fob-ticksify::ticksify.priority'))
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
