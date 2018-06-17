<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat');
            $table->double('lng');
            $table->string('name');
            $table->string('quarter');
            $table->string('street');
            $table->string('house_number');
            $table->string('postcode');
            $table->string('place');
            $table->string('url')->nullable();
            $table->string('phone')->nullable();
            $table->string('branch');
            $table->string('monday_from');
            $table->string('monday_till');
            $table->string('monday_break')->nullable();
            $table->string('tuesday_from');
            $table->string('tuesday_till');
            $table->string('tuesday_break')->nullable();
            $table->string('wednesday_from');
            $table->string('wednesday_till');
            $table->string('wednesday_break')->nullable();
            $table->string('thursday_from');
            $table->string('thursday_till');
            $table->string('thursday_break')->nullable();
            $table->string('friday_from');
            $table->string('friday_till');
            $table->string('friday_break')->nullable();
            $table->string('saturday_from');
            $table->string('saturday_till');
            $table->string('saturday_break')->nullable();
            $table->string('other')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
