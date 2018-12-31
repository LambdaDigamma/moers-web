<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('shops');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat');
            $table->double('lng');
            $table->string('name');
            $table->string('quarter')->nullable();
            $table->string('street');
            $table->string('house_number');
            $table->string('postcode');
            $table->string('place');
            $table->string('url')->nullable();
            $table->string('phone')->nullable();
            $table->string('branch');
            $table->string('monday')->nullable();
            $table->string('tuesday')->nullable();
            $table->string('wednesday')->nullable();
            $table->string('thursday')->nullable();
            $table->string('friday')->nullable();
            $table->string('saturday')->nullable();
            $table->string('sunday')->nullable();
            $table->string('other')->nullable();
            $table->integer('creator_id')->default(1);
            $table->boolean('validated')->default(false);
            $table->timestamps();
        });
    }
}
