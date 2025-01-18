<?php

namespace Modules\Parking\Models;

use App\Models\Model;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Parking\Database\Factories\ParkingAreaFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ParkingArea extends Model implements HasMedia
{
    use HasFactory;
    use HasPostgisColumns;
    use InteractsWithMedia;

    const string OPEN = 'open';

    const string CLOSED = 'closed';

    const string UNKNOWN = 'unknown';

    protected array $postgisColumns = [
        'location' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('snapshot_light')->singleFile();
        $this->addMediaCollection('snapshot_dark')->singleFile();
    }

    public function isOpen(): bool
    {
        return $this->current_opening_state == self::OPEN;
    }

    public function isClosed(): bool
    {
        return $this->current_opening_state == self::CLOSED;
    }

    public function freeSites(): int
    {
        return ($this->capacity ?? 0) - ($this->occupied_sites ?? 0);
    }

    public function scopeOrderByOpeningState($query): Builder
    {
        $driver = $query->getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            return $query->orderByRaw("
            CASE current_opening_state
                WHEN 'open' THEN 1
                WHEN 'closed' THEN 2
                WHEN 'unknown' THEN 3
                ELSE 4
            END
        ");
        }

        // MariaDB/MySQL
        return $query->orderByRaw("FIELD(current_opening_state, 'open', 'closed', 'unknown')");
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('current_opening_state', self::OPEN);
    }

    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('current_opening_state', self::CLOSED);
    }

    public static function openingStateFromString($openingState): string
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

    public static function createSlug($name): string
    {
        return Str::slug($name, '-');
    }

    protected static function newFactory(): ParkingAreaFactory
    {
        return ParkingAreaFactory::new();
    }
}
