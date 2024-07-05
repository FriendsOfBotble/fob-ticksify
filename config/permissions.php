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
        'name' => 'Create',
        'flag' => 'fob-ticksify.tickets.create',
        'parent_flag' => 'fob-ticksify.tickets.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'fob-ticksify.tickets.edit',
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
];
