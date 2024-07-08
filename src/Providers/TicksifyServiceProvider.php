<?php

namespace FriendsOfBotble\Ticksify\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Blog\Models\Post;
use Botble\Ecommerce\Models\Customer;
use Botble\RealEstate\Models\Account;
use FriendsOfBotble\Ticksify\Models\Ticket;
use Illuminate\Contracts\Database\Eloquent\Builder;

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

        add_filter(BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM, function (Builder $query) {
            if ($query->getModel() instanceof Post) {
                $query->where('status', 'hehe');
            }

            return $query;
        }, 999);
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

        DashboardMenu::for(is_plugin_active('ecommerce') ? 'customer' : 'account')
            ->beforeRetrieving(function () {
                DashboardMenu::make()->registerItem([
                    'id' => 'cms-plugins-fob-ticksify-public',
                    'priority' => 90,
                    'name' => __('Tickets'),
                    'url' => fn () => route('fob-ticksify.public.tickets.index'),
                    'icon' => 'ti ti-ticket',
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
            Account::resolveRelationUsing('tickets', function (Account $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('job-board')) {
            \Botble\JobBoard\Models\Account::resolveRelationUsing('tickets', function (\Botble\JobBoard\Models\Account $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        if (is_plugin_active('hotel')) {
            \Botble\Hotel\Models\Account::resolveRelationUsing('tickets', function (\Botble\Hotel\Models\Account $customer) {
                return $customer->morphMany(Ticket::class, 'sender');
            });
        }

        return $this;
    }
}
