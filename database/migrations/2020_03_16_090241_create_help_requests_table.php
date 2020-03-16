<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_requests', function (Blueprint $table) {
            $table->id();
            $table->text('request');
            $table->unsignedBigInteger('quarter_id');
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('helper_id')->nullable();
            $table->timestamp('served_on')->nullable();
            $table->timestamps();
        });
        Schema::table('help_requests', function (Blueprint $table) {
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('helper_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('quarter_id')->references('id')->on('quarters')
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
        Schema::table('help_requests', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('help_requests_creator_id_foreign');
                $table->dropForeign('help_requests_helper_id_foreign');
                $table->dropForeign('help_requests_quarter_id_foreign');
            }
        });
        Schema::dropIfExists('help_requests');
    }
}
