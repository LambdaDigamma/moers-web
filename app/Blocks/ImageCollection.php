<?php

namespace App\Blocks;

use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class ImageCollection extends Block {

    use ValidatesMedia;

    public static string $imagesKey = "images";

    public static function typeIdentifier()
    {
        return 'image-collection';
    }

    public function mediaCollectionRules()
    {
        return [
            self::$imagesKey => $this
                ->validateMultipleMedia()
                ->minItems(0)
                ->maxItems(3)
                ->extension(['png', 'jpg', 'jpeg', 'webp'])
                ->maxItemSizeInKb(1024)
        ];
    }

    public static function mediaCollectionNames()
    {
        return [
            self::$imagesKey,
        ];
    }

}