<?php

namespace Modules\Management\Data;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Symfony\Contracts\Service\Attribute\Required;

class StoreOrganisationRequest extends Data
{
    public function __construct(
        #[Required]
        #[Min(3)]
        #[Max(255)]
        public string $name,
        #[Required]
        #[Min(3)]
        #[Max(255)]
        public string $handle
    ) {}
}
