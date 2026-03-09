<?php

namespace Modules\Management\Data;

use Spatie\LaravelData\Data;

class ShowOrganisationProps extends Data
{
    public function __construct(
        public Organisation $organisation,
        public bool $canEdit = false,
        public bool $canCreateEvents = false,
    ) {}
}
