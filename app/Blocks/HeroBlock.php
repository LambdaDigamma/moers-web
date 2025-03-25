<?php

namespace App\Blocks;

use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class HeroBlock extends Block
{
    use ValidatesMedia;

    public static string $headerKey = "header";

    public static function typeIdentifier()
    {
        return "hero";
    }

    public function mediaCollectionRules()
    {
        return [
            self::$headerKey => $this
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
            self::$headerKey,
        ];
    }
    
}
