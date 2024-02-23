<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->after('remember_token', function (Blueprint $table) {
                $table->foreignId('current_team_id')->nullable();
                $table->text('profile_photo_path')->nullable();
            });
            $table->after('password', function (Blueprint $table) {
                $table->text('two_factor_secret')->nullable();
                $table->text('two_factor_recovery_codes')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes', 'profile_photo_path');
        });
    }
}
