<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInformation extends Model
{

    protected $fillable = [
        'name',
        'nickname',
        'birthday',
        'slogan',
        'motto',
        'strengths',
        'weaknesses',
        'lkA',
        'lkB',
        'highlight',
        'soundtrack',
        'miss_least',
        'miss_most',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
