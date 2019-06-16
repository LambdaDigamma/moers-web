<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{

    use SoftDeletes;

    protected $table = 'organisations';

    protected $fillable = ['name', 'description'];

    public function users() {
        return $this->belongsToMany('App\User')->withPivot('organisation_id', 'user_id', 'role');
    }

    public function entry() {
        return $this->belongsTo('App\Entry');
    }

    public function events() {
        return $this->hasMany('App\AdvEvent')->whereDate('start_date', '>', Carbon::yesterday()->toDateString());
    }

}
