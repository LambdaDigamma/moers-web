<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('mm_feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name')->nullable();
            $table->json('extras')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('mm_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('summary')->nullable();
            $table->json('slug')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->json('external_href')->nullable();
            $table->foreign('page_id')->references('id')->on('mm_pages')
            ->onUpdate('cascade')
            ->onDelete('set null');
            $table->string('guid')->nullable();
            $table->json('extras')->nullable();
            $table->timestamps();
            $table->publishedAt();
            $table->archivedAt();
            $table->softDeletes();
        });

        Schema::create('mm_publications', function (Blueprint $table)
        {
            $table->unsignedBigInteger('feed_id')->index();
            $table->unsignedBigInteger('post_id')->index();

            $table->foreign('feed_id')->references('id')->on('mm_feeds')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('mm_posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('mm_feeds');
        Schema::dropIfExists('mm_posts');
        Schema::dropIfExists('mm_post_feed');
    }

};
