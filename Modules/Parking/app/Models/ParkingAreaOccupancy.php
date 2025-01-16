<?php

namespace Modules\Parking\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Parking\Database\Factories\ParkingAreaOccupancyFactory;

class ParkingAreaOccupancy extends Model
{
    use HasFactory;

    protected static function newFactory(): ParkingAreaOccupancyFactory
    {
        return ParkingAreaOccupancyFactory::new();
    }
}
