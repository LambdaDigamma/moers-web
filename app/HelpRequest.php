<?php

namespace App;

use Auth;

/**
 * App\HelpRequest
 *
 * @property int $id
 * @property string $request
 * @property int $quarter_id
 * @property int $creator_id
 * @property int|null $helper_id
 * @property string|null $served_on
 * @property int|null $conversation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Conversation|null $conversation
 * @property-read \App\User $creator
 * @property-read \App\User|null $helper
 * @property-read \App\Quarter $quarter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest filter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest notServed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest userHelps()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereHelperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereQuarterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereServedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HelpRequest withoutOwn()
 * @mixin \Eloquent
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
