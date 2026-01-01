<?php

namespace App\Data;

use Kreait\Firebase\Messaging\MessageTarget;

final class TokenNotificationTarget extends NotificationTarget
{
    public function __construct(public string $token) {}

    public function getType(): string
    {
        return MessageTarget::TOKEN;
    }

    public function getValue(): string
    {
        return $this->token;
    }
}
