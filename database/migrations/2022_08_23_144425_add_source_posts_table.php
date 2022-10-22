<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mm_posts', function (Blueprint $table) {
            $table->after('guid', function (Blueprint $table) {
                $table->string('source')->nullable();
                $table->unsignedBigInteger('organisation_id')->nullable();
            });
        });
        Schema::table('mm_posts', function (Blueprint $table) {
            $table->foreign('organisation_id')
                ->references('id')
                ->on('organisations')
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
        Schema::table('mm_posts', function (Blueprint $table) {
            //
        });
    }
};
