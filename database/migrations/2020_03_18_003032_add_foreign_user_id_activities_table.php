<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignUserIdActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function(Blueprint $table) {
            $table->unsignedInteger('user_id')->change();
        });
        Schema::table('activities', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('activities_user_id_foreign');
            }
        });
        Schema::table('activities', function(Blueprint $table) {
            $table->integer('user_id')->change();
        });
    }
}
