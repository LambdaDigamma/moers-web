<?php

namespace App\Data;

abstract class NotificationTarget
{
    abstract public function getType(): string;

    abstract public function getValue(): string;
}
