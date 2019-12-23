<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RubbishStreet extends Model
{

    public function pickupItems() {

        $items = RubbishScheduleItem::upcoming()->get();

        $residual = $items->filter(function ($item) {
            return $item->residual_tours->contains($this->residual_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'residual']);
        });

        $organic = $items->filter(function ($item) {
            return $item->organic_tours->contains($this->organic_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'organic']);
        });

        $paper = $items->filter(function ($item) {
            return $item->paper_tours->contains($this->paper_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'paper']);
        });

        $plastic = $items->filter(function ($item) {
            return $item->plastic_tours->contains($this->plastic_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'plastic']);
        });

        $cuttings = $items->filter(function ($item) {
            return $item->cuttings_tours->contains($this->cutting_tour);
        })->map(function ($item) {
            return new RubbishPickupItem(['date' => $item->date, 'type' => 'cuttings']);
        });

        $pickupItems = collect();
        $pickupItems = $pickupItems->merge($residual);
        $pickupItems = $pickupItems->merge($organic);
        $pickupItems = $pickupItems->merge($paper);
        $pickupItems = $pickupItems->merge($plastic);
        $pickupItems = $pickupItems->merge($cuttings);

        return $pickupItems;

    }

    public function scopeCurrent($query) {
        return $query->where('year', '=', Carbon::now()->year);
    }

}
