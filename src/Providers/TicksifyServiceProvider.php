<?php

namespace FriendsOfBotble\Ticksify\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Ecommerce\Models\Customer;
use Botble\JobBoard\Models\Account as JobBoardAccount;
use Botble\RealEstate\Models\Account as RealEstateAccount;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicksifyServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/fob-ticksify')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->registerDashboardMenu()
            ->loadAndPublishViews()
            ->resolveRelations()
            ->loadMigrations()
            ->loadRoutes();
    }

    protected function registerDashboardMenu(): self
    {
        DashboardMenu::beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-plugins-fob-ticksify',
                    'priority' => 999,
                    'name' => 'plugins/fob-ticksify::ticksify.name',
                    'icon' => 'ti ti-ticket',
                    'permissions' => ['fob-ticksify'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-fob-ticksify-tickets',
                    'priority' => 10,
                    'parent_id' => 'cms-plugins-fob-ticksify',
                    'name' => 'plugins/fob-ticksify::ticksify.tickets.name',
                    'url' => fn () => route('fob-ticksify.tickets.index'),
                    'permissions' => ['fob-ticksify.tickets.index'],
                ])
                ->registerItem([
                    'id' => 'cms-plugins-fob-ticksify-categories',
                    'priority' => 20,
                    'parent_id' => 'cms-plugins-fob-ticksify',
                    'name' => 'plugins/fob-ticksify::ticksify.categories.name',
                    'url' => fn () => route('fob-ticksify.categories.index'),
                    'permissions' => ['fob-ticksify.categories.index'],
                ]);
        });

        return $this;
    }

    protected function resolveRelations(): self
    {
        if (is_plugin_active('ecommerce')) {
            Customer::resolveRelationUsing('tickets', function (Customer $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('real-estate')) {
            RealEstateAccount::resolveRelationUsing('tickets', function (RealEstateAccount $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('job-board')) {
            JobBoardAccount::resolveRelationUsing('tickets', function (JobBoardAccount $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        return $this;
    }
}
