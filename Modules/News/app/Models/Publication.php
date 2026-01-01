<?php

namespace Modules\News\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Publication extends Pivot
{
    protected $table = 'publications';
}
