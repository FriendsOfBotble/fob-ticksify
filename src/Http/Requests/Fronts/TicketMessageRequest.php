<?php

namespace FriendsOfBotble\Ticksify\Http\Requests\Fronts;

use Botble\Support\Http\Requests\Request;

class TicketMessageRequest extends Request
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:10000'],
        ];
    }
}
