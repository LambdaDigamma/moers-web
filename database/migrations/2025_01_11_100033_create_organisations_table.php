<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 250)->unique();
            $table->mediumText('description');
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->bigInteger('location_id')->unsigned()->nullable();
            $table->string('tags', 500)->nullable();
            $table->string('logo_url', 250)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('location_id')->references('id')->on('locations')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('organisation_user', function (Blueprint $table) {
            $table->integer('organisation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['organisation_id', 'user_id'])->unique();
        });

        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 500);
            $table->text('description');
            $table->integer('organisation_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->bigInteger('group_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['group_id', 'user_id'])->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisations');
        Schema::dropIfExists('organisation_user');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_user');
    }
};
