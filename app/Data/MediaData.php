<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class MediaData extends Data
{
    public function __construct(
        public int $id,
        public string $model_type,
        public int $model_id,
        public ?string $uuid,
        public string $collection_name,
        public string $name,
        public string $file_name,
        public ?string $mime_type,
        public string $disk,
        public string $conversions_disk,
        public int $size,
        public array $manipulations,
        public array $custom_properties,
        public ?string $alt,
        public ?string $credits,
        public ?string $caption,
        public array $generated_conversions,
        public array $responsive_images,
        public int $order_column,
        public string $created_at,
        public string $updated_at,
        public string $srcset,
        public string $full_url,
        public ?int $responsive_width,
        public ?int $responsive_height,
        public ?string $preview_url,
    ) {}
}
