<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livestream_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livestream_schedule_id')
                ->constrained('livestream_schedules')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livestream_items');
    }
};
