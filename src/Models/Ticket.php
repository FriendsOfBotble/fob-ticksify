<?php

namespace FriendsOfBotble\Ticksify\Models;

use Botble\Base\Models\BaseModel;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Ticket extends BaseModel
{
    protected $table = 'fob_tickets';

    protected $fillable = [
        'category_id',
        'sender_type',
        'sender_id',
        'title',
        'content',
        'priority',
        'status',
        'is_resolved',
        'is_locked',
    ];

    protected $casts = [
        'priority' => TicketPriority::class,
        'status' => TicketStatus::class,
        'is_resolved' => 'bool',
        'is_locked' => 'bool',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'ticket_id');
    }
}
