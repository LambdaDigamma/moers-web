<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->json('description')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('extras')->nullable();
            $table->timestamps();
            $table->publishedAt();
            $table->archivedAt();
            $table->softDeletes();
        });

        Schema::create('ticket_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->decimal('price', 15, 2)->nullable();
            $table->foreignId('ticket_id')
                ->references('id')
                ->on('tickets');
            $table->string('url')->nullable();
            $table->json('extras')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('ticket_id')
                ->references('id')
                ->on('tickets');
            $table->foreignId('event_id')
                ->references('id')
                ->on('events');
            $table->unique(['ticket_id', 'event_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_options');
        Schema::dropIfExists('ticket_assignments');
    }
};
