<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Parking\Models\ParkingArea;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parking_areas', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->string('slug', 255)->default('');
            });
        });

        ParkingArea::query()
            ->get()
            ->each(function ($parkingArea) {
                if ($parkingArea->slug == null) {
                    $parkingArea->slug = ParkingArea::createSlug($parkingArea->name ?? '');
                    $parkingArea->save();
                }
            });
        
        Schema::table('parking_areas', function (Blueprint $table) {
            $table->string('slug', 255)->default(null)->unique()->change();
        });
    }
};
