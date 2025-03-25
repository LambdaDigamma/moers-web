<?php

namespace App\Blocks;

class TipTapTextWithMedia extends Block
{

    public static function typeIdentifier()
    {
        return "tip-tap-text-with-media";
    }

    public static function slotSchema(): array
    {
        return [
            'aside' => [
                VimeoVideo::class
            ]
        ];
    }

}
