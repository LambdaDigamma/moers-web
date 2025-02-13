<?php

namespace Modules\Management\Models;

use App\Models\Model;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Locations\Models\Location;
use Modules\Management\Database\Factories\OrganisationFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organisation extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'organisations';

    protected $fillable = ['name', 'description'];

    protected $appends = ['header_path', 'logo_path'];

    protected static function newFactory(): OrganisationFactory
    {
        return OrganisationFactory::new();
    }

    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class)
            ->withPivot('organisation_id', 'user_id', 'role');
    }

    public function mainGroup(): HasOne
    {
        return $this->hasOne(Group::class);
    }

    //    public function entry(): BelongsTo
    //    {
    //        return $this->belongsTo(Entry::class);
    //    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    protected function headerPath(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMedia('header')?->getUrl());
    }

    protected function logoPath(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMedia('logo')?->getUrl());
    }

    // MARK: - Scopes -

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%');
            })->when($filters['trashed'] ?? null, function ($query, $trashed) {
                if ($trashed === 'with') {
                    $query->withTrashed();
                } elseif ($trashed === 'only') {
                    $query->onlyTrashed();
                }
            });
    }
}
