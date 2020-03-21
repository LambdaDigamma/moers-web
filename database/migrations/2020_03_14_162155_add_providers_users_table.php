<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvidersUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('password')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_id')->nullable()->after('remember_token');
            $table->string('provider')->nullable()->after('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['provider_id', 'provider']);
        });
    }
}
