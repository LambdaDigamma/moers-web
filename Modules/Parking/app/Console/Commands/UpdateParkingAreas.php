<?php

namespace Modules\Parking\Console\Commands;

use App\Http\Integrations\Moers\MoersConnector;
use App\Http\Integrations\Moers\Requests\GetParkingLotsRequest;
use Illuminate\Console\Command;
use Modules\Parking\Models\ParkingArea;
use Modules\Parking\Models\ParkingAreaOccupancy;

class UpdateParkingAreas extends Command
{
    protected $signature = 'parking-area:update';

    protected $description = 'Updates all parking areas from the official Parkleitsystem.';

    public function handle(): int
    {
        $this->info('Updating parking areas...');

        $api = new MoersConnector;
        $request = new GetParkingLotsRequest;

        $response = $api->send($request);

        if ($response->ok()) {

            $records = $response->collect()->get('data');

            $shouldStoreCurrentOccupancy = $this->shouldStoreCurrentOccupancy();

            foreach ($records as $offset => $record) {
                $name = $record['attributes']['name'] ?? null;
                $openingState = $record['OpeningState'] ?? ParkingArea::UNKNOWN;
                $capacity = $record['Capacity'] ?? null;
                $occupied = $record['OccupiedSites'] ?? null;
                $timestamp = $record['Timestamp'] ?? null;
                $openingState = ParkingArea::openingStateFromString($openingState);

                dd($name, $openingState, $capacity, $occupied, $timestamp);

                //
                //                $parkingArea = ParkingArea::updateOrCreate(
                //                    ['name' => $name],
                //                    [
                //                        'name' => $name,
                //                        'slug' => ParkingArea::createSlug($name),
                //                        'capacity' => $capacity,
                //                        'occupied_sites' => $occupied,
                //                        'current_opening_state' => $openingState,
                //                        'updated_at' => Carbon::createFromTimestampMsUTC($timestamp),
                //                    ]
                //                );
                //
                //                if ($shouldStoreCurrentOccupancy) {
                //                    $occupancy_rate = 0;
                //                    if ($capacity > 0) {
                //                        $occupancy_rate = $occupied / $capacity;
                //                    }
                //                    $occupancy_rate = number_format((float) $occupancy_rate, 4, '.', '');
                //
                //                    ParkingAreaOccupancy::create([
                //                        'occupancy_rate' => $occupancy_rate,
                //                        'occupied_sites' => $occupied,
                //                        'capacity' => $capacity,
                //                        'opening_state' => $openingState,
                //                        'parking_area_id' => $parkingArea->id,
                //                    ]);
                //                }
            }

        }

        //        $response = Http::get('https://download.moers.de/PLS/plcinfo.csv');
        //
        //        if ($response->ok()) {
        //            $responseBody = $response->body();
        //            $responseBody = utf8_encode($responseBody);
        //
        //            $reader = Reader::createFromString($responseBody);
        //            $reader->setDelimiter(';');
        //            $reader->setEnclosure('"');
        //            $reader->setHeaderOffset(0);
        //            $records = $reader->getRecords();
        //
        //            $shouldStoreCurrentOccupancy = $this->shouldStoreCurrentOccupancy();
        //
        //            foreach ($records as $offset => $record) {
        //                $name = $record['Name'] ?? null;
        //                $openingState = $record['OpeningState'] ?? ParkingArea::UNKNOWN;
        //                $capacity = $record['Capacity'] ?? null;
        //                $occupied = $record['OccupiedSites'] ?? null;
        //                $timestamp = $record['Timestamp'] ?? null;
        //                $openingState = ParkingArea::openingStateFromString($openingState);
        //
        //                $parkingArea = ParkingArea::updateOrCreate(
        //                    ['name' => $name],
        //                    [
        //                        'name' => $name,
        //                        'slug' => ParkingArea::createSlug($name),
        //                        'capacity' => $capacity,
        //                        'occupied_sites' => $occupied,
        //                        'current_opening_state' => $openingState,
        //                        'updated_at' => Carbon::createFromTimestampMsUTC($timestamp),
        //                    ]
        //                );
        //
        //                if ($shouldStoreCurrentOccupancy) {
        //                    $occupancy_rate = 0;
        //                    if ($capacity > 0) {
        //                        $occupancy_rate = $occupied / $capacity;
        //                    }
        //                    $occupancy_rate = number_format((float) $occupancy_rate, 4, '.', '');
        //
        //                    ParkingAreaOccupancy::create([
        //                        'occupancy_rate' => $occupancy_rate,
        //                        'occupied_sites' => $occupied,
        //                        'capacity' => $capacity,
        //                        'opening_state' => $openingState,
        //                        'parking_area_id' => $parkingArea->id,
        //                    ]);
        //                }
        //            }
        //        }

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
                $this->info('Operation will persist current occupancy.');
            } else {
                $this->warn('Operation will not persist current occupancy.');
            }
        }

        return $shouldStoreCurrentOccupancy;
    }
}
