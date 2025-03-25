<?php

namespace App\Traits;

trait SerializeChildrenSlots
{
    public function serializeChildrenSlots(): array
    {
        return ['slots' => $this->children->groupBy('slot')->toArray()];
    }
}
