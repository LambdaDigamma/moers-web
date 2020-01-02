<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\RubbishStreet
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet current()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereCuttingsTour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereOrganicTour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet wherePaperTour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet wherePlasticTour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereResidualTour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereStreetAddition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RubbishStreet whereYear($value)
 * @mixin \Eloquent
 */
class RubbishStreet extends Model
{

    public function pickupItems() {

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

    public function scopeCurrent($query) {
        return $query->where('year', '=', Carbon::now()->year);
    }

}
