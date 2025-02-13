<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat');
            $table->double('lng');
            $table->string('name');
            $table->string('tags', 1000);
            $table->string('street');
            $table->string('house_number');
            $table->string('postcode');
            $table->string('place');
            $table->string('url')->nullable();
            $table->json('opening_hours')->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('is_validated')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
