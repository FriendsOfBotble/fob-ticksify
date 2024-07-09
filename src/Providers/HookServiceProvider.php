<?php

namespace FriendsOfBotble\Ticksify\Providers;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\ServiceProvider;
use Botble\Table\Abstracts\TableAbstract;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use FriendsOfBotble\Ticksify\Models\Ticket;
use FriendsOfBotble\Ticksify\Tables\TicketTable;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter(BASE_FILTER_APPEND_MENU_NAME, function (?string $html, string $id): ?string {
            if ($id !== 'cms-plugins-fob-ticksify-tickets' && $id !== 'cms-plugins-fob-ticksify') {
                return $html;
            }

            $tickets = Ticket::query()
                ->where('status', TicketStatus::OPEN)
                ->count();

            return $html .
                Html::tag(
                    'span',
                    trans('plugins/fob-ticksify::ticksify.menu_counter', ['count' => number_format($tickets)]),
                    ['class' => 'badge bg-warning text-warning-fg']
                );
        }, 999, 2);

        add_filter(BASE_FILTER_TABLE_BEFORE_RENDER, function (?string $html, TableAbstract $table): ?string {
            if (! $table instanceof TicketTable) {
                return $html;
            }

            $stats = Ticket::query()
                ->withStatistics()
                ->first();

            $statUrl = function (?string $status = null) {
                $params = [];

                if ($status !== null) {
                    $params = [
                        'filter_table_id' => 'friends-of-botble-ticksify-tables-ticket-table',
                        'class' => TicketTable::class,
                        'filter_columns' => ['status'],
                        'filter_operators' => ['='],
                        'filter_values' => [$status],
                    ];
                }

                return route('fob-ticksify.tickets.index', $params);
            };

            return $html . view('plugins/fob-ticksify::tickets.partials.stats', compact('stats', 'statUrl'));
        }, 999, 2);
    }
}
