<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name', 255);
            $table->string('nickname', 255);
            $table->string('birthday', 255);
            $table->string('slogan', 255);
            $table->string('motto', 255);
            $table->string('strengths', 255);
            $table->string('weaknesses', 255);
            $table->string('lkA', 255);
            $table->string('lkB', 255);
            $table->string('highlight', 400);
            $table->string('soundtrack', 100);
            $table->string('miss_least', 255);
            $table->string('miss_most', 255);
            $table->string('photo_old_path', 100)->nullable();
            $table->string('photo_new_path', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_information', function(Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['student_information_user_id_foreign']);
            }
        });
        Schema::dropIfExists('student_information');
    }
}
