<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubbish_schedule_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('residual_tours')->nullable();
            $table->string('organic_tours')->nullable();
            $table->string('paper_tours')->nullable();
            $table->string('plastic_tours')->nullable();
            $table->string('cuttings_tours')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubbish_schedule_items');
    }
};
