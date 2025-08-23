<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubbish_streets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('street_addition')->nullable();
            $table->integer('residual_tour');
            $table->integer('organic_tour');
            $table->integer('paper_tour');
            $table->integer('plastic_tour');
            $table->integer('cuttings_tour');
            $table->year('year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubbish_streets');
    }
};
