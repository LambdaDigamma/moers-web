<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quarters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('postcode', 5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quarters');
    }
};
