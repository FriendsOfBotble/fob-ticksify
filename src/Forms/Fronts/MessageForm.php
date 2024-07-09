<?php

namespace FriendsOfBotble\Ticksify\Forms\Fronts;

use Botble\Base\Forms\FieldOptions\ButtonFieldOption;
use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Theme\Facades\Theme;
use Botble\Theme\FormFront;
use FriendsOfBotble\Ticksify\Models\Message;

class MessageForm extends FormFront
{
    public function setup(): void
    {
        if (! is_in_admin()) {
            Theme::asset()->add('ticksify', 'vendor/core/plugins/fob-ticksify/css/front-ticksify.css');
            Theme::asset()
                ->container('footer')
                ->add('ticksify', 'vendor/core/plugins/fob-ticksify/js/front-ticksify.js');
        }

        $this
            ->model(Message::class)
            ->contentOnly()
            ->when(is_in_admin(), function (MessageForm $form) {
                $form
                    ->add(
                        'content',
                        EditorField::class,
                        EditorFieldOption::make()
                            ->rows(2),
                    );
            }, function (MessageForm $form) {
                $form
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
                    );
            })
            ->add(
                'submit',
                'submit',
                ButtonFieldOption::make()
                    ->cssClass('btn btn-primary mt-3')
                    ->label(__('Reply'))
            );
    }
}
