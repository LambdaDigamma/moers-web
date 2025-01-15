<?php

namespace Modules\Events\Generators;

use Modules\Events\Data\Link;

interface Generator
{
    /**
     * Generate an URL to add event to calendar.
     */
    public function generate(Link $link): string;
}
