<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubbishStreetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubbish_streets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('street_addition')->nullable();
            $table->integer('residual_tour');
            $table->integer('organic_tour');
            $table->integer('paper_tour');
            $table->integer('yellow_bag_tour');
            $table->integer('green_cut_tour');
            $table->year('year');
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
        Schema::dropIfExists('rubbish_streets');
    }
}
