<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class ParkingArea extends StandardModel
{
    use HasFactory;
    use SpatialTrait;

    const OPEN = "open";
    const CLOSED = "closed";
    const UNKNOWN = "unknown";

    protected $spatialFields = [
        'location',
    ];

    public function isOpen()
    {
        return $this->current_opening_state == self::OPEN;
    }

    public function isClosed()
    {
        return $this->current_opening_state == self::CLOSED;
    }

    public function freeSites(): int {
        return ($this->capacity ?? 0) - ($this->occupied_sites ?? 0);
    }

    public function scopeOrderByOpeningState($query)
    {
        $query->orderByRaw("FIELD(current_opening_state, 'open', 'closed', 'unknown')");
    }

    public function scopeOpen($query)
    {
        $query->where('current_opening_state', self::OPEN);
    }

    static function openingStateFromString($openingState): string
    {
        switch ($openingState) {
            case ParkingArea::OPEN:
                return ParkingArea::OPEN;
            case ParkingArea::CLOSED:
                return ParkingArea::CLOSED;
            case ParkingArea::UNKNOWN:
                return ParkingArea::UNKNOWN;
        }

        switch ($openingState) {
            case 'Geöffnet':
                return ParkingArea::OPEN;
            case 'Geschlossen':
                return ParkingArea::CLOSED;
            case 'Unbekannt':
                return ParkingArea::UNKNOWN;
            default:
                return ParkingArea::UNKNOWN;
        }
    }
}
