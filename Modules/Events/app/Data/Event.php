<?php

namespace Modules\Events\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class Event extends Data
{
    public function __construct(
        #[MapInputName('id')]
        public int $id,
        #[MapInputName('name')]
        public string $name,
        #[MapInputName('start_date')]
        public ?Carbon $startDate,
        #[MapInputName('end_date')]
        public ?Carbon $endDate,
        #[MapInputName('description')]
        public ?string $description,
        #[MapInputName('pageId')]
        public ?int $pageId,

        #[MapInputName('created_at')]
        public ?Carbon $createdAt,
        #[MapInputName('updated_at')]
        public ?Carbon $updatedAt,
        #[MapInputName('published_at')]
        public ?Carbon $publishedAt,
        #[MapInputName('cancelled_at')]
        public ?Carbon $cancelledAt,
        #[MapInputName('archived_at')]
        public ?Carbon $archivedAt,
        #[MapInputName('deleted_at')]
        public ?Carbon $deletedAt,
    )
    {

    }
}
