<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('lat');
            $table->double('lng');
            $table->json('name');
            $table->string('street_name')->nullable();
            $table->string('street_number')->nullable();
            $table->string('address_addition')->nullable();
            $table->string('postalcode')->nullable();
            $table->string('postal_town')->nullable();
            $table->string('country_code')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('tags')->nullable();
            $table->string('url')->nullable();
            $table->string('phone')->nullable();
            $table->json('extras')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
