<?php

namespace App\Traits;

use App\Models\Media;

trait SerializeMedia
{
    public function serializeMediaCollections(): array
    {
        return [
            'media_collections' => $this->media
                ->filter(fn (Media $media): bool => $media->existsOnDisk())
                ->groupBy('collection_name')
                ->toArray(),
        ];
    }
}
