<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixDeletionForeignCreatorPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('pages', function (Blueprint $table) {
//            if (DB::getDriverName() !== 'sqlite') {
//                $table->dropForeign('pages_creator_id_foreign');
//            }
//        });
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('pages_creator_id_foreign');
            }
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
