<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{

    use SoftDeletes;

    protected $table = 'organisations';

    protected $fillable = ['name', 'description'];

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function entry() {
        return $this->belongsTo('App\Entry');
    }

}
