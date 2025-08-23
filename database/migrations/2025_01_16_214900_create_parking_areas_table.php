<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug', 255)->default(null)->unique();
            $table->magellanPoint('location', 4326)->nullable();
            $table->string('current_opening_state')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->unsignedInteger('occupied_sites')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking_areas');
    }
};
