<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->string('email')->nullable()->after('logo_url');
            $table->string('phone')->nullable()->after('email');
            $table->string('website_url')->nullable()->after('phone');
            $table->string('street')->nullable()->after('website_url');
            $table->string('postcode', 20)->nullable()->after('street');
            $table->string('city')->nullable()->after('postcode');
            $table->string('external_source')->nullable()->after('city');
            $table->string('external_id')->nullable()->after('external_source');
            $table->string('external_url')->nullable()->after('external_id');

            $table->unique(['external_source', 'external_id']);
        });
    }

    public function down(): void
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropUnique(['external_source', 'external_id']);
            $table->dropColumn([
                'email',
                'phone',
                'website_url',
                'street',
                'postcode',
                'city',
                'external_source',
                'external_id',
                'external_url',
            ]);
        });
    }
};
