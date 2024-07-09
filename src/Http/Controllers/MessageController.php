<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use FriendsOfBotble\Ticksify\Forms\MessageForm;
use FriendsOfBotble\Ticksify\Http\Requests\MessageRequest;
use FriendsOfBotble\Ticksify\Models\Message;
use FriendsOfBotble\Ticksify\Tables\MessageTable;

class MessageController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/fob-ticksify::ticksify.name'))
            ->add(
                trans('plugins/fob-ticksify::ticksify.messages.name'),
                route('fob-ticksify.messages.index')
            );
    }

    public function index(MessageTable $messageTable)
    {
        $this->pageTitle(trans('plugins/fob-ticksify::ticksify.messages.name'));

        return $messageTable->renderTable();
    }

    public function edit(Message $message)
    {
        $this->pageTitle(trans('core/base::forms.edit'));

        return MessageForm::createFromModel($message)->renderForm();
    }

    public function update(Message $message, MessageRequest $request)
    {
        $form = MessageForm::createFromModel($message)->setRequest($request);
        $form->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('fob-ticksify.messages.index')
            ->setNextRoute(
                'fob-ticksify.messages.edit',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Message $message)
    {
        return DeleteResourceAction::make($message);
    }
}
