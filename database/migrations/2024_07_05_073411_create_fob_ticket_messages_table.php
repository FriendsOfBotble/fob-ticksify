<?php

use Botble\Base\Enums\BaseStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('fob_ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->morphs('sender');
            $table->foreignId('ticket_id');
            $table->text('content');
            $table->string('status', 60)->default(BaseStatusEnum::PUBLISHED);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fob_ticket_messages');
    }
};
