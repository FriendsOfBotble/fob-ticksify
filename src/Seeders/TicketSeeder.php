<?php

namespace FriendsOfBotble\Ticksify\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Supports\BaseSeeder;
use Botble\Ecommerce\Models\Customer;
use Botble\RealEstate\Models\Account;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use FriendsOfBotble\Ticksify\Models\Category;
use FriendsOfBotble\Ticksify\Models\Message;
use FriendsOfBotble\Ticksify\Models\Ticket;

class TicketSeeder extends BaseSeeder
{
    public function run(): void
    {
        Category::query()->truncate();
        Ticket::query()->truncate();
        Message::query()->truncate();

        $categories = [
            'Orders',
            'Technical Support',
            'FAQS',
            'Feedback',
            'Bug Report',
            'Feature Request',
            'Account and Login',
            'Payment and Billing',
            'Security and Privacy',
        ];

        $tickets = [
            'Issue with order processing',
            'Error in login functionality',
            'Feature request: Dark mode support',
            'Website performance degradation',
            'Unable to process payments',
            'Mobile app crashing on startup',
            'Password reset not working',
            'Missing email notifications',
            'Request for account deletion',
            'Security vulnerability report',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'status' => BaseStatusEnum::PUBLISHED,
            ]);
        }

        $faker = $this->fake();
        $categories = Category::query()->pluck('id');
        $userQuery = match (true) {
            is_plugin_active('ecommerce') => Customer::query(),
            is_plugin_active('real-estate') => Account::query(),
            is_plugin_active('job-board') => \Botble\JobBoard\Models\Account::query(),
            is_plugin_active('hotel') => \Botble\Hotel\Models\Account::query(),
        };
        $users = $userQuery->pluck('id');

        foreach ($tickets as $ticket) {
            Ticket::create([
                'category_id' => $categories->random(),
                'sender_type' => $userQuery->getModel()->getMorphClass(),
                'sender_id' => $users->random(),
                'title' => $ticket,
                'content' => $faker->paragraphs(3, true),
                'priority' => $faker->randomElement(TicketPriority::values()),
                'status' => $faker->randomElement(TicketStatus::values()),
                'is_locked' => $faker->boolean(10),
                'is_resolved' => $faker->boolean(20),
                'created_at' => $faker->dateTimeBetween('-1 month'),
            ]);
        }
    }
}
