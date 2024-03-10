<?php

namespace Modules\Rubbish\Models;

use App\Models\Model;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\RubbishStreet
 *
 * @property int $id
 * @property string $name
 * @property string|null $street_addition
 * @property int $residual_tour
 * @property int $organic_tour
 * @property int $paper_tour
 * @property int $plastic_tour
 * @property int $cuttings_tour
 * @property string $year
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|RubbishStreet current()
 * @method static Builder|RubbishStreet newModelQuery()
 * @method static Builder|RubbishStreet newQuery()
 * @method static Builder|RubbishStreet query()
 * @method static Builder|RubbishStreet whereCreatedAt($value)
 * @method static Builder|RubbishStreet whereCuttingsTour($value)
 * @method static Builder|RubbishStreet whereId($value)
 * @method static Builder|RubbishStreet whereName($value)
 * @method static Builder|RubbishStreet whereOrganicTour($value)
 * @method static Builder|RubbishStreet wherePaperTour($value)
 * @method static Builder|RubbishStreet wherePlasticTour($value)
 * @method static Builder|RubbishStreet whereResidualTour($value)
 * @method static Builder|RubbishStreet whereStreetAddition($value)
 * @method static Builder|RubbishStreet whereUpdatedAt($value)
 * @method static Builder|RubbishStreet whereYear($value)
 * @mixin Eloquent
 */
class RubbishStreet extends Model
{
    use HasFactory;

    public $casts = [
        'year' => 'integer'
    ];

    public function pickupItems()
    {
        $items = RubbishScheduleItem::upcoming()->get();

        $residual_tour = $this->residual_tour;
        $organic_tour = $this->organic_tour;
        $paper_tour = $this->paper_tour;
        $plastic_tour = $this->plastic_tour;
        $cutting_tour = $this->cutting_tour;

        $residual = $items->filter(function ($item) use ($residual_tour) {
            return $item->residual_tours->contains($residual_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'residual']);
        });

        $organic = $items->filter(function ($item) use ($organic_tour) {
            return $item->organic_tours->contains($organic_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'organic']);
        });

        $paper = $items->filter(function ($item) use ($paper_tour) {
            return $item->paper_tours->contains($paper_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'paper']);
        });

        $plastic = $items->filter(function ($item) use ($plastic_tour) {
            return $item->plastic_tours->contains($plastic_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'plastic']);
        });

        $cuttings = $items->filter(function ($item) use ($cutting_tour) {
            return $item->cuttings_tours->contains($cutting_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'cuttings']);
        });

        $pickupItems = collect();
        $pickupItems = $pickupItems->merge($residual);
        $pickupItems = $pickupItems->merge($organic);
        $pickupItems = $pickupItems->merge($paper);
        $pickupItems = $pickupItems->merge($plastic);
        $pickupItems = $pickupItems->merge($cuttings);

        return $pickupItems->sortBy('date')->values();
    }

    public function scopeCurrent($query)
    {
        return $query->where('year', '=', Carbon::now()->year);
    }
}
