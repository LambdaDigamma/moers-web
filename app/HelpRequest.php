<?php

namespace App;

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

}
