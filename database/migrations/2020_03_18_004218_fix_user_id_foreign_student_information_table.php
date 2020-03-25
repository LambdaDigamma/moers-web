<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixUserIdForeignStudentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('student_information', function (Blueprint $table) {
//            if (DB::getDriverName() !== 'sqlite') {
//                $table->dropForeign(['user_id']);
//            }
//        });
        Schema::table('student_information', function (Blueprint $table) {
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
        Schema::table('student_information', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
            }
        });
        Schema::table('student_information', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
