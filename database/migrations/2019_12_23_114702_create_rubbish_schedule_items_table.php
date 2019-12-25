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
            $table->string('residual_tours')->nullable();
            $table->string('organic_tours')->nullable();
            $table->string('paper_tours')->nullable();
            $table->string('plastic_tours')->nullable();
            $table->string('cuttings_tours')->nullable();
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
