<?php

namespace App\Models;

use App\Traits\SerializeTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RadioBroadcast extends Model
{
    use HasFactory;
    use SerializeTranslations;
    
    public $translatable = ['title', 'description'];
    public $fillable = ['title', 'description', 'starts_at', 'ends_at', 'uid', 'url', 'attach'];
    public $dates = ['starts_at', 'ends_at'];

}