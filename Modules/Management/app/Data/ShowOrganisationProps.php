<?php

namespace Modules\Management\Data;

use Spatie\LaravelData\Data;

class ShowOrganisationProps extends Data
{
    public function __construct(
        public Organisation $organisation
    ) {}
}
