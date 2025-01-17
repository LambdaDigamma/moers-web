<?php

namespace App\Traits;

trait SerializeMedia
{
    public function serializeMediaCollections(): array
    {
        return ['media_collections' => $this->media->groupBy('collection_name')->toArray()];
    }
}
