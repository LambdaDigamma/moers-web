<?php

namespace Modules\News\Models;

use App\Traits\SerializeTranslations;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\Database\Factories\FeedFactory;

class Feed extends Model
{
    use HasFactory;
    use SerializeTranslations;
    use SoftDeletes;

    protected $table = 'feeds';

    protected $guarded = ['*', 'id'];

    public array $translatable = ['name', 'extras'];

    public static function newFactory(): FeedFactory
    {
        return FeedFactory::new();
    }

    public function scopeByIdentifier(Builder $query, string $identifier): Builder
    {
        return $query->where('identifier', $identifier);
    }

    public function scopeByIdOrIdentifier(Builder $query, string|int $idOrIdentifier): Builder
    {
        if (is_numeric($idOrIdentifier)) {
            return $query->where(function ($query) use ($idOrIdentifier) {
                $query->where('id', $idOrIdentifier)
                    ->orWhere('identifier', $idOrIdentifier);
            });
        }

        return $query->where('identifier', $idOrIdentifier);
    }

    public function posts(): BelongsToMany
    {
        return $this
            ->belongsToMany(Post::class, 'publications', 'feed_id', 'post_id')
            ->using(Publication::class)
            ->as('publication')
            ->withPivot('order')
            ->withTimestamps()
            ->chronological()
            ->orderByPivot('order');
    }

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

    public function toArray(): array
    {
        $attributes = parent::toArray();

        return $this->serializeTranslations($attributes);
    }
}
