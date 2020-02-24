<?php

use App\AdvEvent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTranslatableAdvEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adv_events', function (Blueprint $table) {
            $table->json('name')->change();
            $table->json('description')->nullable()->change();
            $table->json('category')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adv_events', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('description')->nullable()->change();
            $table->string('category', 1000)->nullable()->change();
        });
    }
}
