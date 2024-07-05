<?php

namespace FriendsOfBotble\Ticksify\Forms;

use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use FriendsOfBotble\Ticksify\Http\Requests\CategoryRequest;
use FriendsOfBotble\Ticksify\Models\Category;

class CategoryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Category::class)
            ->setValidatorClass(CategoryRequest::class)
            ->add(
                'name',
                TextField::class,
                NameFieldOption::make()
                    ->required()
                    ->maxLength(255),
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make(),
            );
    }
}
