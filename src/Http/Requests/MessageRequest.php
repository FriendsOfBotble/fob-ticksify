<?php

namespace FriendsOfBotble\Ticksify\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MessageRequest extends Request
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:10000'],
            'status' => [Rule::in(BaseStatusEnum::values())],
        ];
    }
}
