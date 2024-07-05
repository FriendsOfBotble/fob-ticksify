<?php

namespace FriendsOfBotble\Ticksify\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\StatusColumn;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicketTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Ticket::class)
            ->addActions([
                EditAction::make()->route('fob-ticksify.tickets.edit'),
                DeleteAction::make()->route('fob-ticksify.tickets.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkChanges([
                StatusBulkChange::make(),
            ])
            ->addBulkAction(DeleteBulkAction::make());
    }
}
