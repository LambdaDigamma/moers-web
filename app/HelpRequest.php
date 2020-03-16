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

}
