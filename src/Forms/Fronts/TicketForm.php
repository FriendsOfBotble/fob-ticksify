<?php

namespace FriendsOfBotble\Ticksify\Forms\Fronts;

use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Theme\Facades\Theme;
use Botble\Theme\FormFront;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Models\Category;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicketForm extends FormFront
{
    public function setup(): void
    {
        Theme::asset()
            ->container('footer')
            ->add('ticksify', 'vendor/core/plugins/fob-ticksify/js/front-ticksify.js');

        $categories = Category::query()
            ->wherePublished()
            ->pluck('name', 'id')
            ->all();

        $this
            ->model(Ticket::class)
            ->contentOnly()
            ->setUrl(route('fob-ticksify.public.tickets.store'))
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Subject'))
                    ->placeholder(__('Briefly describe your issue'))
            )
            ->add(
                'category_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(__('Category'))
                    ->choices($categories),
            )
            ->add(
                'trix-editor',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->label(__('Content'))
                    ->content('<trix-editor input="content"></trix-editor>')
            )
            ->add(
                'content',
                'hidden',
                TextFieldOption::make()
                    ->addAttribute('id', 'content')
            )
            ->add(
                'priority',
                SelectField::class,
                SelectFieldOption::make()
                    ->wrapperAttributes(['class' => 'my-3 position-relative'])
                    ->label(__('Priority'))
                    ->choices(TicketPriority::labels())
                    ->defaultValue(TicketPriority::MEDIUM)
            )
            ->add(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->cssClass('btn btn-primary mt-3')
                    ->label(__('Submit')),
            );
    }
}
