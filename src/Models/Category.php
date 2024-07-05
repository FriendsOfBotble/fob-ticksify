<?php

namespace FriendsOfBotble\Ticksify\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Category extends BaseModel
{
    protected $table = 'fob_ticket_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
