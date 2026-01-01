<?php

namespace App\Blocks;

use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class AudioPlayer extends Block
{
    use ValidatesMedia;

    public static function typeIdentifier()
    {
        return 'audio-player';
    }

    public static string $audioFileKey = 'audio_file';

    public function mediaCollectionRules()
    {
        return [
            self::$audioFileKey => $this
                ->validateSingleMedia()
                ->extension(['mp3'])
                ->maxItemSizeInKb(50 * 1024),
        ];
    }

    public static function mediaCollectionNames()
    {
        return [
            self::$audioFileKey,
        ];
    }
}
