<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMediaTable extends Migration
{
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {

            $table->uuid('uuid')->nullable();
            $table->string('conversions_disk')->nullable();

        });
    }

    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'conversions_disk']);
        });
    }

}
