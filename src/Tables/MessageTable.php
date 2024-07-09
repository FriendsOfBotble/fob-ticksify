<?php

namespace FriendsOfBotble\Ticksify\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\LinkableColumn;
use Botble\Table\Columns\StatusColumn;
use FriendsOfBotble\Ticksify\Models\Message;
use Illuminate\Database\Eloquent\Builder;

class MessageTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Message::class)
            ->queryUsing(fn (Builder $query) => $query->with('ticket'))
            ->addActions([
                EditAction::make()->route('fob-ticksify.messages.edit'),
                DeleteAction::make()->route('fob-ticksify.messages.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                LinkableColumn::make('ticket_id')
                    ->label(trans('plugins/fob-ticksify::ticksify.ticket'))
                    ->urlUsing(fn (LinkableColumn $column) => route('fob-ticksify.tickets.show', $column->getItem()->ticket_id))
                    ->getValueUsing(fn (LinkableColumn $column) => $column->getItem()->ticket->title),
                Column::make('content')
                    ->label(trans('plugins/fob-ticksify::ticksify.content')),
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
