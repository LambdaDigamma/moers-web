<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radio_broadcasts', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->string('url', 2000)->nullable();
            $table->string('attach', 2000)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radio_broadcasts');
    }
};
