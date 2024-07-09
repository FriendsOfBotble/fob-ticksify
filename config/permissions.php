<?php

return [
    [
        'name' => 'FOB Ticksify',
        'flag' => 'fob-ticksify',
    ],
    [
        'name' => 'Tickets',
        'flag' => 'fob-ticksify.tickets.index',
        'parent_flag' => 'fob-ticksify',
    ],
    [
        'name' => 'View',
        'flag' => 'fob-ticksify.tickets.show',
        'parent_flag' => 'fob-ticksify.tickets.index',
    ],
    [
        'name' => 'Update',
        'flag' => 'fob-ticksify.tickets.update',
        'parent_flag' => 'fob-ticksify.tickets.index',
    ],
    [
        'name' => 'Reply',
        'flag' => 'fob-ticksify.tickets.messages.store',
        'parent_flag' => 'fob-ticksify.tickets.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'fob-ticksify.tickets.destroy',
        'parent_flag' => 'fob-ticksify.tickets.index',
    ],

    [
        'name' => 'Ticket Categories',
        'flag' => 'fob-ticksify.categories.index',
        'parent_flag' => 'fob-ticksify',
    ],
    [
        'name' => 'Create',
        'flag' => 'fob-ticksify.categories.create',
        'parent_flag' => 'fob-ticksify.categories.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'fob-ticksify.categories.edit',
        'parent_flag' => 'fob-ticksify.categories.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'fob-ticksify.categories.destroy',
        'parent_flag' => 'fob-ticksify.categories.index',
    ],

    [
        'name' => 'Messages',
        'flag' => 'fob-ticksify.messages.index',
        'parent_flag' => 'fob-ticksify',
    ],
    [
        'name' => 'Edit',
        'flag' => 'fob-ticksify.messages.edit',
        'parent_flag' => 'fob-ticksify.messages.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'fob-ticksify.messages.destroy',
        'parent_flag' => 'fob-ticksify.messages.index',
    ],
];
