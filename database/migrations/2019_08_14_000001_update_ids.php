<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Silber\Bouncer\Database\Models;

class UpdateIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        $this->dropForeign('assigned_roles', ['role_id']);
        $this->dropForeign('permissions', ['ability_id']);

        Schema::table('abilities', function(Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
            $table->unsignedBigInteger('entity_id')->nullable()->change();
        });

        Schema::table('roles', function(Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('assigned_roles', function(Blueprint $table) {
            $table->bigIncrements('id')->after('entity_id');
            $table->unsignedBigInteger('role_id')->unsigned()->change();
            $table->unsignedBigInteger('entity_id')->unsigned()->change();
            $table->unsignedBigInteger('restricted_to_id')->unsigned()->nullable()->change();

            $table->foreign('role_id')
                ->references('id')->on(Models::table('roles'))
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('permissions', function(Blueprint $table) {
            $table->bigIncrements('id')->after('entity_id');
            $table->unsignedBigInteger('ability_id')->change();
            $table->unsignedBigInteger('entity_id')->nullable()->change();
            $table->foreign('ability_id')
                ->references('id')->on(Models::table('abilities'))
                ->onUpdate('cascade')->onDelete('cascade');
        });

        $this->dropForeign('activities', ['user_id']);
        $this->dropForeign('audits', ['user_id']);
        $this->dropForeign('conversation_user', ['user_id']);
        $this->dropForeign('entries', ['user_id']);
        $this->dropForeign('group_user', ['user_id']);
        $this->dropForeign('help_requests', ['helper_id']);
        $this->dropForeign('help_requests', ['creator_id']);
        $this->dropForeign('messages', ['sender_id']);
        $this->dropForeign('organisation_user', ['user_id']);
        $this->dropForeign('pages', ['creator_id']);
        $this->dropForeign('student_information', ['user_id']);
        $this->dropForeign('votes', ['user_id']);

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('audits', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('conversation_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('entries', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('group_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('help_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->change();
            $table->unsignedBigInteger('helper_id')->nullable()->change();
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('helper_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('sender_id')->change();
            $table->foreign('sender_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('organisation_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->nullable()->change();
            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('student_information', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('votes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
            $table->unsignedBigInteger('associated_object_index')->change();
        });

        Schema::table('adv_events', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('audits', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        $this->dropForeign('events', ['entry_id']);
        $this->dropForeign('adv_events', ['entry_id']);
        $this->dropForeign('organisations', ['entry_id']);

        Schema::table('entries', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('entry_id')->nullable()->change();
            $table->foreign('entry_id')->references('id')->on('entries')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('adv_events', function (Blueprint $table) {
            $table->unsignedBigInteger('entry_id')->nullable()->change();
            $table->foreign('entry_id')->references('id')->on('entries')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('organisations', function (Blueprint $table) {
            $table->unsignedBigInteger('entry_id')->nullable()->change();
            $table->foreign('entry_id')->references('id')->on('entries')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        $this->dropForeign('adv_events', ['organisation_id']);
        $this->dropForeign('events', ['organisation_id']);
        $this->dropForeign('groups', ['organisation_id']);
        $this->dropForeign('organisation_user', ['organisation_id']);

        Schema::table('organisations', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('adv_events', function (Blueprint $table) {
            $table->unsignedBigInteger('organisation_id')->nullable()->change();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('organisation_id')->nullable()->change();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedBigInteger('organisation_id')->nullable()->change();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('organisation_user', function (Blueprint $table) {
            $table->unsignedBigInteger('organisation_id')->change();
            $table->foreign('organisation_id')->references('id')->on('organisations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();

    }

    protected function dropForeign($tableName, array $foreign)
    {
        Schema::table($tableName, function (Blueprint $table) use ($foreign) {
            $table->dropForeign($foreign);
        });
    }

}
