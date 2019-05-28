<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvEvent extends Model
{

    use SoftDeletes;

    protected $table = 'adv_events';

    protected $fillable = ['name', 'date', 'start_date', 'end_date',
        'description', 'url', 'image_path', 'category',
        'organisation_id', 'entry_id', 'extras', 'is_published'];

    protected $casts = [
        'extras' => 'array'
    ];

    public function organisation() {
        return $this->belongsTo('App\Organisation');
    }

    public function entry() {
        return $this->belongsTo('App\Entry');
    }

}
