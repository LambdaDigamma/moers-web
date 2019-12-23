<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RubbishStreet extends Model
{



    public function scheduleItems() {

        return RubbishScheduleItem::all()->filter(function ($item) {

            if ($item->residual_tours->contains($this->residual_tour)) {
                $item->
                return true;
            }
            if ($item->organic_tours->contains($this->organic_tour)) {
                return true;
            }
            if ($item->paper_tours->contains($this->paper_tour)) {
                return true;
            }
            if ($item->plastic_tours->contains($this->plastic_tour)) {
                return true;
            }
            if ($item->cuttings_tours->contains($this->cuttings_tour)) {
                return true;
            }

            return false;

        });

    }

    public function scopeCurrent($query) {
        return $query->where('year', '=', Carbon::now()->year);
    }

}
