<?php

namespace App\Blocks;

use App\Models\PageBlock;
use Exception;
use Spatie\LaravelData\Data;
//use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

abstract class Block extends Data implements Blockable
{
    // todo: validate media
//    use ValidatesMedia;

    public function __construct(PageBlock $block)
    {
        $this->guardAgainstType($block->type);
    }

    public function mediaCollectionRules(): array
    {
        return [];
    }

    public static function mediaCollectionNames(): array
    {
        return [];
    }

    public static function slotSchema(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    public function guardAgainstType($blockTypeIdentifier): void
    {
        if ($blockTypeIdentifier != static::typeIdentifier()) {
            throw new Exception("The type of the provided block does not match this wrapper.");
        }
    }
}
