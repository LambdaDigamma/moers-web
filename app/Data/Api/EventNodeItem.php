<?php

namespace App\Data\Api;

use Swis\JsonApi\Client\Interfaces\OneRelationInterface;
use Swis\JsonApi\Client\Item;
use Swis\JsonApi\Client\Relations\HasOneRelation;

class EventNodeItem extends Item
{
    protected $type = 'node--event';

    public function field_evt_media_venue_ref(): OneRelationInterface|HasOneRelation
    {
        return $this->hasOne(MediaCompanyItem::class);
    }
}
