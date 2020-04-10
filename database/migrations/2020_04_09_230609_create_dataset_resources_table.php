<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatasetResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataset_resources', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('source_url')->nullable();
            $table->string('format');
            $table->boolean('is_valid')->default(false);
            $table->unsignedBigInteger('auto_updating_interval')->nullable();
            $table->unsignedBigInteger('dataset_id');
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
        Schema::dropIfExists('dataset_resources');
    }
}
