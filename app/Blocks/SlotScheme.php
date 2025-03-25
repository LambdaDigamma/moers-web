<?php

namespace App\Blocks;

class SlotScheme
{
    public string $identifier;
    public string $title;
    public array $allowedBlockIdentifiers = [];

    public function __construct($identifier, $title, $allowedBlockIdentifiers = [])
    {
        $this->identifier = $identifier;
        $this->title = $title;
        $this->allowedBlockIdentifiers = $allowedBlockIdentifiers;
    }

}