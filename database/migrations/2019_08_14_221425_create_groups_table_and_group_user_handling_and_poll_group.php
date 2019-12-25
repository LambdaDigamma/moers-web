<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTableAndGroupUserHandlingAndPollGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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

        Schema::table('organisations', function (Blueprint $table) {
            $table->bigInteger('group_id')->unsigned()->nullable()->after('entry_id');
        });

        Schema::table('polls', function (Blueprint $table) {
            $table->bigInteger('group_id')->unsigned()->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign('organisation_id');
        });
        Schema::table('group_user', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'group_id']);
        });
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn(['group_id']);
        });
        Schema::table('polls', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_user');
    }
}
