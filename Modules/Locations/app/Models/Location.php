<?php

namespace Modules\Locations\Models;

use App\Traits\SerializeTranslations;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Locations\Database\factories\LocationFactory;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use HasFactory;
    use HasTranslations;
    use SerializeTranslations;
    use SoftDeletes;

    protected $table = 'locations';

    protected $guarded = ['*', 'id'];

    protected $translatable = ['name', 'tags'];

    protected $casts = [
        'tags' => 'array',
        'extras' => 'array',
        'validated_at' => 'datetime',
    ];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%')
                ->orWhere('street_name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    protected static function newFactory(): LocationFactory
    {
        return LocationFactory::new();
    }

    public function scopeValidated($query)
    {
        return $query->where('validated_at', '!=', null);
    }
}
