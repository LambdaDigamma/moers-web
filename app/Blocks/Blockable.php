<?php

namespace App\Blocks;

interface Blockable
{
    public static function typeIdentifier();

    public function mediaCollectionRules();

    public static function mediaCollectionNames();
}
