<?php

namespace FriendsOfBotble\Ticksify\Forms;

use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Theme\Facades\Theme;
use Botble\Theme\FormFront;
use FriendsOfBotble\Ticksify\Models\Message;

class MessageForm extends FormFront
{
    public function setup(): void
    {
        Theme::asset()->add('ticksify', 'vendor/core/plugins/fob-ticksify/css/ticksify.css');

        Theme::asset()
            ->container('footer')
            ->add('ticksify', 'vendor/core/plugins/fob-ticksify/js/ticksify.js');

        $this
            ->model(Message::class)
            ->contentOnly()
            ->add(
                'trix-editor',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content('<trix-editor input="content"></trix-editor>')
            )
            ->add(
                'content',
                'hidden',
                TextFieldOption::make()
                    ->addAttribute('id', 'content')
            )
            ->add(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->cssClass('btn btn-primary mt-3')
                    ->label(__('Reply'))
            );
    }
}
