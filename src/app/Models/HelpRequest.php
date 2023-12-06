<?php

namespace App\Models;

use Auth;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\HelpRequest
 *
 * @property int $id
 * @property string $request
 * @property int $quarter_id
 * @property int $creator_id
 * @property int|null $helper_id
 * @property string|null $served_on
 * @property int|null $conversation_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Conversation|null $conversation
 * @property-read User $creator
 * @property-read User|null $helper
 * @property-read Quarter $quarter
 * @method static Builder|HelpRequest filter($filters)
 * @method static Builder|HelpRequest newModelQuery()
 * @method static Builder|HelpRequest newQuery()
 * @method static Builder|HelpRequest notServed()
 * @method static Builder|HelpRequest query()
 * @method static Builder|HelpRequest userHelps()
 * @method static Builder|HelpRequest whereConversationId($value)
 * @method static Builder|HelpRequest whereCreatedAt($value)
 * @method static Builder|HelpRequest whereCreatorId($value)
 * @method static Builder|HelpRequest whereHelperId($value)
 * @method static Builder|HelpRequest whereId($value)
 * @method static Builder|HelpRequest whereQuarterId($value)
 * @method static Builder|HelpRequest whereRequest($value)
 * @method static Builder|HelpRequest whereServedOn($value)
 * @method static Builder|HelpRequest whereUpdatedAt($value)
 * @method static Builder|HelpRequest withoutOwn()
 * @mixin Eloquent
 */
class HelpRequest extends Model
{

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

    public function helper()
    {
        return $this->belongsTo(User::class, 'helper_id', 'id');
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class, 'quarter_id', 'id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereHas('quarter', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('postcode', 'like', '%'.$search.'%');
            })->orWhere('request', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function scopeNotServed($query)
    {
        return $query->whereNull('served_on');
    }

    public function scopeWithoutOwn($query)
    {
        if (!Auth::guest()) {
            return $query->where('creator_id', '!=', Auth::user()->id);
        }
    }

    public function scopeUserHelps($query)
    {
        if (!Auth::guest()) {
            return $query->where('helper_id', '=', Auth::user()->id);
        }
    }

}
