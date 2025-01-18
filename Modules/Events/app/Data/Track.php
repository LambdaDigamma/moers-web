<?php

namespace Modules\Events\Data;

use Spatie\LaravelData\Data;

class Track extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $color = 'red',
        public array $items = [],
    ) {}
}
