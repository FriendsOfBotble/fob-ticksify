<?php

namespace FriendsOfBotble\Ticksify\Models;

use Botble\Base\Models\BaseModel;
use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Query\Builder as QueryBuilder;

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

    protected static function boot(): void
    {
        parent::boot();

        static::deleted(function (Ticket $ticket) {
            $ticket->messages()->delete();
        });
    }

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

    public function scopeWithStatistics(Builder $query): QueryBuilder
    {
        return $query
            ->toBase()
            ->selectRaw('count(*) as total')
            ->selectRaw('count(if(status = "open", 1, null)) as open')
            ->selectRaw('count(if(status = "in_progress", 1, null)) as in_progress')
            ->selectRaw('count(if(status = "closed", 1, null)) as closed')
            ->selectRaw('count(if(status = "on_hold", 1, null)) as on_hold');
    }
}
