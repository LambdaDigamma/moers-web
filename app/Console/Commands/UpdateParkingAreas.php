<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ParkingArea;
use App\Models\ParkingAreaOccupancy;
use Cache;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use League\Csv\Reader;

class UpdateParkingAreas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking-area:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates all parking areas from the official Parkleitsystem.';

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
        $this->info('Updating parking areas...');
        $response = Http::get('https://download.moers.de/PLS/plcinfo.csv');

        if ($response->ok()) {
            $responseBody = $response->body();
            $responseBody = utf8_encode($responseBody);

            $reader = Reader::createFromString($responseBody);
            $reader->setDelimiter(';');
            $reader->setEnclosure('"');
            $reader->setHeaderOffset(0);
            $records = $reader->getRecords();

            $shouldStoreCurrentOccupancy = $this->shouldStoreCurrentOccupancy();

            foreach ($records as $offset => $record) {
                $name = $record['Name'] ?? null;
                $openingState = $record['OpeningState'] ?? ParkingArea::UNKNOWN;
                $capacity = $record['Capacity'] ?? null;
                $occupied = $record['OccupiedSites'] ?? null;
                $timestamp = $record['Timestamp'] ?? null;
                
                $parkingArea = ParkingArea::updateOrCreate(
                    ['name' => $name],
                    [
                        'name' => $name,
                        'capacity' => $capacity,
                        'occupied_sites' => $occupied,
                        'current_opening_state' => ParkingArea::openingStateFromString($openingState),
                        'updated_at' => Carbon::createFromTimestampMsUTC($timestamp),
                    ]
                );

                if ($shouldStoreCurrentOccupancy) {
                    $occupancy_rate = 0;
                    if ($capacity > 0) {
                        $occupancy_rate = $occupied / $capacity;
                    }
    
                    ParkingAreaOccupancy::create([
                        'occupancy_rate' => $occupancy_rate,
                        'occupied_sites' => $occupied,
                        'capacity' => $capacity,
                        'parking_area_id' => $parkingArea->id,
                    ]);
                }
            }
        }

        return 0;
    }

    public function shouldStoreCurrentOccupancy(): bool 
    {
        $shouldStoreCurrentOccupancy = true;
        $lastOccupancy = ParkingAreaOccupancy::query()->latest()->first();

        if (! $lastOccupancy) {
            return true;
        }

        $lastUpdated = $lastOccupancy->created_at;

        if ($lastUpdated) {
            $diffInMinutes = now()->diffInMinutes($lastUpdated);
            $shouldStoreCurrentOccupancy = $diffInMinutes >= 5;
            $this->info("Last persisting of occupancy was {$diffInMinutes} minutes ago.");
            
            if ($shouldStoreCurrentOccupancy) {
                $this->info("Operation will persist current occupancy.");
            } else {
                $this->warn("Operation will not persist current occupancy.");
            }
        }
        return $shouldStoreCurrentOccupancy;
    }
}
