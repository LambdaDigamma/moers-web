<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adv_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->longText('description')->nullable();
            $table->string('url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('category')->nullable();
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->integer('entry_id')->unsigned()->nullable();
            $table->boolean('is_published')->default(1);
            $table->json('extras')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('adv_events');
    }
}
