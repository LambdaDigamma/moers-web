<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('mm_page_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->timestamps();
        });

        Schema::create('mm_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('summary')->nullable();
            $table->json('keywords')->nullable();
            $table->bigInteger('page_template_id')->unsigned()->nullable();
            $table->foreign('page_template_id')->references('id')->on('mm_page_templates')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->json('extras')->nullable();
            $table->timestamps();
            $table->archivedAt();
            $table->publishedAt();
            $table->softDeletes();
        });

        Schema::table('mm_pages', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('mm_menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title')->nullable();
            $table->json('fragment')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('mm_pages')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('mm_menu_items')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();
        });

        Schema::table('mm_pages', function (Blueprint $table) {
            $table->after('keywords', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_menu_item_id')->nullable();
                $table->foreign('parent_menu_item_id')->references('id')->on('mm_menu_items')
                    ->onUpdate('cascade')
                    ->onDelete('set null');
            });
        });

        Schema::create('mm_page_blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('mm_pages')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('type');
            $table->json('data')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('mm_page_blocks')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('slot')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();
            $table->publishedAt();
            $table->hiddenAt();
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
        Schema::dropIfExists('mm_page_blocks');
        Schema::dropIfExists('mm_page_templates');
        Schema::dropIfExists('mm_pages');
        Schema::dropIfExists('mm_menu_items');
    }

};
