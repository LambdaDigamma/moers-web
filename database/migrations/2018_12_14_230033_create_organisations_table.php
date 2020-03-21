<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->mediumText('description');
            $table->integer('entry_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('entry_id')->references('id')->on('entries')
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisation_user', function(Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
                $table->dropForeign(['organisation_id']);
            }
        });
        Schema::table('organisations', function(Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['entry_id']);
            }
        });
        Schema::dropIfExists('organisations');
        Schema::dropIfExists('organisation_user');
    }
}
