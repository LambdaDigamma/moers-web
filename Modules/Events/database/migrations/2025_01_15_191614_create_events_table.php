<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->json('description')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('url')->nullable();
            $table->json('category')->nullable();
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->integer('place_id')->unsigned()->nullable();
            $table->uuid('platform_id')->nullable()->unique();
            $table->json('extras')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
            $table->publishedAt();
            $table->timestamp('cancelled_at')->nullable();
            $table->archivedAt();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
