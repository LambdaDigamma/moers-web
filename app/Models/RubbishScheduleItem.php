<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Tightenco\Collect\Support\Collection;

/**
 * App\Models\RubbishScheduleItem
 *
 * @property int $id
 * @property string $date
 * @property array $residual_tours
 * @property array $organic_tours
 * @property array $paper_tours
 * @property array $plastic_tours
 * @property array $cuttings_tours
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|RubbishScheduleItem newModelQuery()
 * @method static Builder|RubbishScheduleItem newQuery()
 * @method static Builder|RubbishScheduleItem query()
 * @method static Builder|RubbishScheduleItem upcoming()
 * @method static Builder|RubbishScheduleItem whereCreatedAt($value)
 * @method static Builder|RubbishScheduleItem whereCuttingsTours($value)
 * @method static Builder|RubbishScheduleItem whereDate($value)
 * @method static Builder|RubbishScheduleItem whereId($value)
 * @method static Builder|RubbishScheduleItem whereOrganicTours($value)
 * @method static Builder|RubbishScheduleItem wherePaperTours($value)
 * @method static Builder|RubbishScheduleItem wherePlasticTours($value)
 * @method static Builder|RubbishScheduleItem whereResidualTours($value)
 * @method static Builder|RubbishScheduleItem whereUpdatedAt($value)
 * @mixin Eloquent
 */
class RubbishScheduleItem extends Model
{


    /**
     * Returns the array of residual tours.
     *
     * @param $value
     *
     * @return array
     */
    public function getResidualToursAttribute($value)
    {
        return $this->explodeBaseTour($value);
    }

    /**
     * Converts array to string and saves it.
     *
     * @param $value
     */
    public function setResidualToursAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['residual_tours'] = implode(',', $value);
        } else {
            $this->attributes['residual_tours'] = $value;
        }
    }

    /**
     * Returns the array of organic tours.
     *
     * @param $value
     *
     * @return array
     */
    public function getOrganicToursAttribute($value)
    {
        return $this->explodeBaseTour($value);
    }

    /**
     * Converts array to string and saves it.
     *
     * @param $value
     */
    public function setOrganicToursAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['organic_tours'] = implode(',', $value);
        } else {
            $this->attributes['organic_tours'] = $value;
        }
    }

    /**
     * Returns the array of paper tours.
     *
     * @param $value
     *
     * @return array
     */
    public function getPaperToursAttribute($value)
    {
        return $this->explodeBaseTour($value);
    }

    /**
     * Converts array to string and saves it.
     *
     * @param $value
     */
    public function setPaperToursAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['paper_tours'] = implode(',', $value);
        } else {
            $this->attributes['paper_tours'] = $value;
        }
    }

    /**
     * Returns the array of plastic tours.
     *
     * @param $value
     *
     * @return array
     */
    public function getPlasticToursAttribute($value)
    {
        return $this->explodeBaseTour($value);
    }

    /**
     * Converts array to string and saves it.
     *
     * @param $value
     */
    public function setPlasticToursAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['plastic_tours'] = implode(',', $value);
        } else {
            $this->attributes['plastic_tours'] = $value;
        }
    }

    /**
     * Returns the array of plastic tours.
     *
     * @param $value
     *
     * @return array
     */
    public function getCuttingsToursAttribute($value)
    {
        return $this->explodeBaseTour($value);
    }

    /**
     * Converts array to string and saves it.
     *
     * @param $value
     */
    public function setCuttingsToursAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['cuttings_tours'] = implode(',', $value);
        } else {
            $this->attributes['cuttings_tours'] = $value;
        }
    }

    public function scopeUpcoming($query)
    {
        $query->whereDate('date', '>=', Carbon::today()->toDateString());
    }

    /**
     * Small helper to exploding the different tour ids.
     *
     * @param $value
     *
     * @return \Illuminate\Support\Collection|Collection
     */
    private function explodeBaseTour($value)
    {
        $tours = explode(',', $value);

        if ($tours != [""] && $tours != null) {
            return collect($tours);
        } else {
            return collect();
        }
    }
}
