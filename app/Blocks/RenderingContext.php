<?php

namespace App\Blocks;

class RenderingContext
{
    public ?string $parentBlockType = null;

    public function __construct(string $parentBlockType)
    {
        $this->parentBlockType = $parentBlockType;
    }
}
