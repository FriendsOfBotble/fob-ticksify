<?php

namespace FriendsOfBotble\Ticksify\Http\Requests;

use Botble\Base\Rules\OnOffRule;
use Botble\Support\Http\Requests\Request;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use Illuminate\Validation\Rule;

class TicketRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => [Rule::in(TicketStatus::values())],
            'priority' => [Rule::in(TicketPriority::values())],
            'is_resolved' => [new OnOffRule()],
            'is_locked' => [new OnOffRule()],
        ];
    }
}
