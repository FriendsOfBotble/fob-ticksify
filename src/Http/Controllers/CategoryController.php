<?php

namespace FriendsOfBotble\Ticksify\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Supports\Breadcrumb;
use FriendsOfBotble\Ticksify\Forms\CategoryForm;
use FriendsOfBotble\Ticksify\Http\Requests\CategoryRequest;
use FriendsOfBotble\Ticksify\Models\Category;
use FriendsOfBotble\Ticksify\Tables\CategoryTable;

class CategoryController extends BaseController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/fob-ticksify::ticksify.name'))
            ->add(
                trans('plugins/fob-ticksify::ticksify.categories.name'),
                route('fob-ticksify.categories.index')
            );
    }

    public function index(CategoryTable $categoryTable)
    {
        $this->pageTitle(trans('plugins/fob-ticksify::ticksify.categories.name'));

        return $categoryTable->renderTable();
    }

    public function create()
    {
        $this->pageTitle(trans('core/base::forms.create'));

        return CategoryForm::create()->renderForm();
    }

    public function store(CategoryRequest $request)
    {
        $form = CategoryForm::create()->setRequest($request);
        $form->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('fob-ticksify.categories.index')
            ->setNextRoute(
                'fob-ticksify.categories.edit',
                $form->getModel()->getKey()
            )
            ->withCreatedSuccessMessage();
    }

    public function edit(Category $category)
    {
        $this->pageTitle(trans('core/base::forms.edit'));

        return CategoryForm::createFromModel($category)->renderForm();
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $form = CategoryForm::createFromModel($category)->setRequest($request);
        $form->saveOnlyValidatedData();

        return $this
            ->httpResponse()
            ->setPreviousRoute('fob-ticksify.categories.index')
            ->setNextRoute(
                'fob-ticksify.categories.edit',
                $form->getModel()->getKey()
            )
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Category $category)
    {
        return DeleteResourceAction::make($category);
    }
}
