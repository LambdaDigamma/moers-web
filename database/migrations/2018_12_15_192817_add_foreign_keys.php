<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('events', function(Blueprint $table) {
            $table->foreign('entry_id')->references('id')->on('entries')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('organisation_id')->references('id')->on('organisations')
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

        Schema::table('events', function(Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['entry_id']);
                $table->dropForeign(['organisation_id']);
            }
        });


    }
}
