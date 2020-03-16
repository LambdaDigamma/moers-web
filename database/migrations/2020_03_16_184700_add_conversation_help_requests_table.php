<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConversationHelpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('help_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('conversation_id')->nullable()->after('served_on');
        });
        Schema::table('help_requests', function (Blueprint $table) {
            $table->foreign('conversation_id')->references('id')->on('conversations')
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
                $table->dropForeign('help_requests_conversation_id_foreign');
            }
            $table->dropColumn('conversation_id');
        });
    }
}
