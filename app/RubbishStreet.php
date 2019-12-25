<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
