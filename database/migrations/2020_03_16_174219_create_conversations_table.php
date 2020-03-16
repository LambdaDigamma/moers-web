<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        Schema::create('conversation_user', function (Blueprint $table) {
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('conversation_id')->references('id')->on('conversations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->index(['conversation_id', 'user_id'])->unique();
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
        Schema::table('conversation_user', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign('conversation_user_user_id_foreign');
                $table->dropForeign('conversation_user_conversation_id_foreign');
            }
        });
        Schema::dropIfExists('conversation_user');
        Schema::dropIfExists('conversations');
    }
}
