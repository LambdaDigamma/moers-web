<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ParkingArea;
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
        $response = Http::get('https://download.moers.de/PLS/plcinfo.csv');

        if ($response->ok()) {

            $responseBody = $response->body();
            $responseBody = utf8_encode($responseBody);

            $reader = Reader::createFromString($responseBody);
            $reader->setDelimiter(';');
            $reader->setEnclosure('"');
            $reader->setHeaderOffset(0);
            $records = $reader->getRecords();
            foreach ($records as $offset => $record) {
                
                $name = $record['Name'] ?? null;
                $openingState = $record['OpeningState'] ?? ParkingArea::UNKNOWN;
                $capacity = $record['Capacity'] ?? null;
                $occupied = $record['OccupiedSites'] ?? null;
                $timestamp = $record['Timestamp'] ?? null;
                
                ParkingArea::updateOrCreate(
                    ['name' => $name],
                    [
                        'name' => $name,
                        'capacity' => $capacity,
                        'occupied_sites' => $occupied,
                        'current_opening_state' => ParkingArea::openingStateFromString($openingState),
                        'updated_at' => Carbon::createFromTimestampMsUTC($timestamp),
                    ]
                );

            }
        }

        return 0;
    }
}
