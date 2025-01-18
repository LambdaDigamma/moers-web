<?php

namespace Modules\Events\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class TrackItem extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public Carbon $start_date,
        public int $duration = 30,
        public ?string $color = 'blue',
        public ?string $href = null,
        public array $extras = [],
    ) {}
}
