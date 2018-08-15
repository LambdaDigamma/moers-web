<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    public function user() {

        return User::where('user_id', '=', $this->user_id)->firstOrFail();

    }

}
