<?php

namespace FriendsOfBotble\Ticksify\Http\Requests\Fronts;

use Botble\Support\Http\Requests\Request;
use FriendsOfBotble\Ticksify\Models\Category;
use Illuminate\Validation\Rule;

class TicketRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'category_id' => ['required', 'string', Rule::exists(Category::class, 'id')],
            'content' => ['required', 'string', 'min:20', 'max:10000'],
        ];
    }
}
