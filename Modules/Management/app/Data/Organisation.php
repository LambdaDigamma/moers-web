<?php

namespace Modules\Management\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class Organisation extends Data
{
    public function __construct(
        #[MapInputName('id')]
        public int $id,
        #[MapInputName('name')]
        public string $name,
        #[MapInputName('slug')]
        public string $slug,
        #[MapInputName('description')]
        public string $description,
        #[MapInputName('created_at')]
        public Carbon $createdAt,
        #[MapInputName('updated_at')]
        public Carbon $updatedAt,
    )
    {

    }
}
