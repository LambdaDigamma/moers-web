<?php

namespace App\Data;

use Kreait\Firebase\Messaging\MessageTarget;

final class TopicNotificationTarget extends NotificationTarget
{
    public function __construct(public string $topic) {}

    public function getType(): string
    {
        return MessageTarget::TOPIC;
    }

    public function getValue(): string
    {
        return $this->topic;
    }
}
