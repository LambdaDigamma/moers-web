<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnreadLastActiveConversationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversation_user', function (Blueprint $table) {
            $table->boolean('is_unread')->default(false)->after('user_id');
            $table->timestamp('last_active')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversation_user', function (Blueprint $table) {
            $table->dropColumn('is_unread');
            $table->dropColumn('last_active');
        });
    }
}
