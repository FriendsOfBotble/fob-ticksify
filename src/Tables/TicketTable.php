<?php

namespace FriendsOfBotble\Ticksify\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\DateTimeColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\LinkableColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use FriendsOfBotble\Ticksify\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;

class TicketTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Ticket::class)
            ->queryUsing(fn (Builder $query) => $query->with(['category', 'sender']))
            ->addActions([
                EditAction::make()->route('fob-ticksify.tickets.show'),
                DeleteAction::make()->route('fob-ticksify.tickets.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('sender_type')
                    ->label(trans('plugins/fob-ticksify::ticksify.user'))
                    ->getValueUsing(fn (FormattedColumn $column) => $column->getItem()->sender->name),
                NameColumn::make('title')
                    ->label(trans('plugins/fob-ticksify::ticksify.title'))
                    ->route('fob-ticksify.tickets.show'),
                LinkableColumn::make('category_id')
                    ->label(trans('plugins/fob-ticksify::ticksify.category'))
                    ->urlUsing(fn (LinkableColumn $column) => route('fob-ticksify.categories.edit', $column->getItem()->category_id))
                    ->getValueUsing(fn (LinkableColumn $column) => $column->getItem()->category->name),
                StatusColumn::make()->alignStart(),
                DateTimeColumn::make('created_at'),
            ])
            ->addBulkChanges([
                StatusBulkChange::make()
                    ->choices(TicketStatus::labels()),
                StatusBulkChange::make()
                    ->name('priority')
                    ->title(trans('plugins/fob-ticksify::ticksify.priority'))
                    ->choices(TicketPriority::labels()),
            ])
            ->addBulkAction(DeleteBulkAction::make());
    }
}
