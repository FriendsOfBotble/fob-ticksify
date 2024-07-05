<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use FriendsOfBotble\Ticksify\Forms\TicketForm;
use FriendsOfBotble\Ticksify\Http\Requests\CategoryRequest;
use FriendsOfBotble\Ticksify\Models\Category;
use FriendsOfBotble\Ticksify\Tables\TicketTable;

class TicketController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/fob-ticksify::ticksify.name'))
            ->add(
                trans('plugins/fob-ticksify::ticksify.tickets.name'),
                route('fob-ticksify.tickets.index')
            );
    }

    public function index(TicketTable $ticketTable)
    {
        $this->pageTitle(trans('plugins/fob-ticksify::ticksify.tickets.name'));

        return $ticketTable->renderTable();
    }

    public function edit(Category $category)
    {
        $this->pageTitle(trans('core/base::forms.edit'));

        return TicketForm::createFromModel($category)->renderForm();
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $ticketForm = TicketForm::createFromModel($category)->setRequest($request);
        $ticketForm->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('fob-ticksify.tickets.index')
            ->setNextRoute(
                'fob-ticksify.tickets.edit',
                $ticketForm->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Category $category)
    {
        return DeleteResourceAction::make($category);
    }
}
