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
        Schema::table('parking_area_occupancies', function (Blueprint $table) {
            $table->after('capacity', function (Blueprint $table) {
                $table->string('opening_state')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parking_area_occupancies', function (Blueprint $table) {
            //
        });
    }
};
