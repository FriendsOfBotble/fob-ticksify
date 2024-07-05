<?php

namespace FriendsOfBotble\Ticksify\Models;

use Botble\Base\Models\BaseModel;

class Message extends BaseModel
{
    protected $table = 'fob_ticket_message';

    protected $fillable = [
        'sender_id',
        'sender_type',
        'ticket_id',
        'message',
    ];
}
