<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRubbishScheduleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubbish_schedule_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('residual_tours');
            $table->string('organic_tours');
            $table->string('paper_tours');
            $table->string('plastic_tours');
            $table->string('cuttings_tours');
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
        Schema::dropIfExists('rubbish_schedule_items');
    }
}
