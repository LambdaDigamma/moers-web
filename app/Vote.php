<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    protected $table = 'votes';
    protected $fillable = ['poll_id', 'user_id'];


}
