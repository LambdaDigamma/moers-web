<?php

namespace App\Jobs;

use App\Services\AppleMapSnapshot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Parking\Models\ParkingArea;

class GenerateParkingAreaSnapshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parkingArea;
    public int $width = 600;
    public int $height = 400;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ParkingArea $parkingArea)
    {
        $this->parkingArea = $parkingArea;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lng = $this->parkingArea->location->getLng();
        $lat = $this->parkingArea->location->getLat();
        
        $light = $this->generate($lat, $lng, false);
        $dark = $this->generate($lat, $lng, true);

        $this->parkingArea
            ->addMediaFromUrl($light)
            ->toMediaCollection('snapshot_light');

        $this->parkingArea
            ->addMediaFromUrl($dark)
            ->toMediaCollection('snapshot_dark');
    }

    private function generate($lat, $lng, $dark = false): string
    {
        return AppleMapSnapshot::signedURL('auto', [
            'z' => '13',
            'lang' => 'de-DE',
            'scale' => 2,
            'poi' => 0,
            'colorScheme' => $dark ? 'dark' : 'light',
            'size' => "{$this->width}x{$this->height}",
            'annotations' => [
                [
                    'point' => "$lat,$lng",
                    'color' => '2563EB',
                    'markerStyle' => 'large',
                    'glyphText' => 'P',
                ]
            ]
        ]);
    }
}
