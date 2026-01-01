<?php

namespace Modules\Waste\Models;

use App\Models\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Waste\Database\Factories\RubbishScheduleItemFactory;

class RubbishScheduleItem extends Model
{
    use HasFactory;

    protected static function newFactory(): RubbishScheduleItemFactory
    {
        return RubbishScheduleItemFactory::new();
    }

    public function getResidualToursAttribute($value): Collection
    {
        return $this->explodeBaseTour($value);
    }

    public function setResidualToursAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['residual_tours'] = implode(',', $value);
        } else {
            $this->attributes['residual_tours'] = $value;
        }
    }

    public function getOrganicToursAttribute($value): Collection
    {
        return $this->explodeBaseTour($value);
    }

    public function setOrganicToursAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['organic_tours'] = implode(',', $value);
        } else {
            $this->attributes['organic_tours'] = $value;
        }
    }

    public function getPaperToursAttribute($value): Collection
    {
        return $this->explodeBaseTour($value);
    }

    public function setPaperToursAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['paper_tours'] = implode(',', $value);
        } else {
            $this->attributes['paper_tours'] = $value;
        }
    }

    public function getPlasticToursAttribute($value): Collection
    {
        return $this->explodeBaseTour($value);
    }

    public function setPlasticToursAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['plastic_tours'] = implode(',', $value);
        } else {
            $this->attributes['plastic_tours'] = $value;
        }
    }

    public function getCuttingsToursAttribute($value): Collection
    {
        return $this->explodeBaseTour($value);
    }

    public function setCuttingsToursAttribute($value): void
    {
        if (is_array($value)) {
            $this->attributes['cuttings_tours'] = implode(',', $value);
        } else {
            $this->attributes['cuttings_tours'] = $value;
        }
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->whereDate('date', '>=', Carbon::today()->toDateString());
    }

    private function explodeBaseTour($value): Collection
    {
        $tours = explode(',', $value);

        if ($tours != [''] && $tours != null) {
            return collect($tours);
        } else {
            return collect();
        }
    }
}
