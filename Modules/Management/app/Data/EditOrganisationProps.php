<?php

namespace Modules\Management\Data;

use Spatie\LaravelData\Data;

class EditOrganisationProps extends Data
{
    public function __construct(
        public Organisation $organisation
    ) {}
}
