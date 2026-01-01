<?php

namespace Modules\Parking\Console\Commands;

use Illuminate\Console\Command;
use Modules\Parking\Jobs\GenerateParkingAreaSnapshot as GenerateParkingAreaSnapshotJob;
use Modules\Parking\Models\ParkingArea;

class GenerateParkingAreaSnapshot extends Command
{
    protected $signature = 'parking-area:generate-snapshots';

    protected $description = 'Generate light and dark map snapshots for all parking areas.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $parkingAreas = ParkingArea::all();
        $this->info("Found {$parkingAreas->count()} parking areas.");

        $parkingAreas->each(function ($parkingArea) {
            GenerateParkingAreaSnapshotJob::dispatchSync($parkingArea);
        });

        $this->info('Generated light and dark map snapshots.');

        return 0;
    }
}
