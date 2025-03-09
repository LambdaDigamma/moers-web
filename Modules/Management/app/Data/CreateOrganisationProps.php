<?php

namespace Modules\Management\Data;

use Spatie\LaravelData\Data;

class CreateOrganisationProps extends Data
{
    public function __construct(
        public string $host
    )
    {

    }
}
