<?php

namespace FriendsOfBotble\Ticksify\Forms;

use Botble\ACL\Models\User;
use Botble\Base\Facades\Html;
use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\FormAbstract;
use FriendsOfBotble\Ticksify\Http\Requests\MessageRequest;
use FriendsOfBotble\Ticksify\Models\Message;

class MessageForm extends FormAbstract
{
    public function setup(): void
    {
        /** @var Message $model */
        $model = $this->getModel();

        $this
            ->model(Message::class)
            ->setValidatorClass(MessageRequest::class)
            ->setBreakFieldPoint('status')
            ->add(
                'ticket_id',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->disabled()
                    ->label(trans('plugins/fob-ticksify::ticksify.ticket'))
                    ->content(Html::link(route('fob-ticksify.tickets.show', $model->ticket), $model->ticket->title, ['class' => 'd-block mb-3']))
            )
            ->add(
                'sender_id',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->disabled()
                    ->label(trans('plugins/fob-ticksify::ticksify.user'))
                    ->content(function () use ($model) {
                        $route = match ($model->sender_type) {
                            User::class => 'users.profile.view',
                            default => 'account.edit',
                        };

                        return Html::link(route($route, $model->sender), $model->sender->name, ['class' => 'd-block mb-3']);
                    })
            )
            ->add(
                'content',
                EditorField::class,
                EditorFieldOption::make()
                    ->required()
                    ->maxLength(10000),
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make(),
            );
    }
}
