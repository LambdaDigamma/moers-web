<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeUpcoming($query) {
        $query->whereDate('date', '>=', Carbon::today()->toDateString());
    }

    /**
     * Small helper to exploding the different tour ids.
     *
     * @param $value
     *
     * @return \Illuminate\Support\Collection|\Tightenco\Collect\Support\Collection
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
