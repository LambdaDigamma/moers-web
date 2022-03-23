<?php

namespace App\Console\Commands;

use App\Jobs\GenerateParkingAreaSnapshot as GenerateParkingAreaSnapshotJob;
use App\Models\ParkingArea;
use Illuminate\Console\Command;

class GenerateParkingAreaSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking-area:generate-snapshots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate light and dark map snapshots for all parking areas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $parkingAreas = ParkingArea::all();
        $this->info("Found {$parkingAreas->count()} parking areas.");

        $parkingAreas->each(function ($parkingArea) {
            GenerateParkingAreaSnapshotJob::dispatchSync($parkingArea);
        });

        $this->info("Generated light and dark map snapshots.");

        return 0;
    }
}
