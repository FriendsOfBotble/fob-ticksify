<?php

namespace FriendsOfBotble\Ticksify\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use FriendsOfBotble\Ticksify\Models\Category;

class CategoryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Category::class)
            ->addHeaderAction(
                CreateHeaderAction::make()->route('fob-ticksify.categories.create')
            )
            ->addActions([
                EditAction::make()->route('fob-ticksify.categories.edit'),
                DeleteAction::make()->route('fob-ticksify.categories.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('fob-ticksify.categories.edit'),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
            ])
            ->addBulkAction(DeleteBulkAction::make());
    }
}
