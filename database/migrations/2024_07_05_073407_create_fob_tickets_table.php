<?php

use FriendsOfBotble\Ticksify\Enums\TicketPriority;
use FriendsOfBotble\Ticksify\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('fob_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->morphs('sender');
            $table->string('title');
            $table->text('content');
            $table->string('priority', 60)->default(TicketPriority::LOW);
            $table->string('status', 60)->default(TicketStatus::OPEN);
            $table->boolean('is_resolved')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fob_tickets');
    }
};
