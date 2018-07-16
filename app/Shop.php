<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    protected $guarded = [];

    public function creator() {

        return User::where('id', '=', $this->creator_id)->firstOrFail();

    }

}
