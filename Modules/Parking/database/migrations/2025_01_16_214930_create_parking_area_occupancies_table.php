<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_area_occupancies', function (Blueprint $table) {
            $table->id();
            $table->decimal('occupancy_rate', 5, 4)->unsigned();
            $table->unsignedInteger('occupied_sites');
            $table->unsignedInteger('capacity');
            $table->string('opening_state')->nullable();
            $table->unsignedBigInteger('parking_area_id');
            $table->foreign('parking_area_id')
                ->references('id')
                ->on('parking_areas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('parking_area_occupancies');
    }
};
