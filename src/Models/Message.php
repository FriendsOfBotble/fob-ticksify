<?php

namespace FriendsOfBotble\Ticksify\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends BaseModel
{
    protected $table = 'fob_ticket_messages';

    protected $fillable = [
        'sender_id',
        'sender_type',
        'ticket_id',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }
}
