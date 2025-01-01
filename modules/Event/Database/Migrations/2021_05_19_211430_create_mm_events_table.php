<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mm_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->json('description')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('url', 2000)->nullable();
            $table->string('image_path', 2000)->nullable();
            $table->json('category', 1000)->nullable();
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->integer('place_id')->unsigned()->nullable();
            $table->uuid('platform_id')->nullable()->unique();
            $table->json('extras')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->archivedAt();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mm_events');
    }
};
