<?php

namespace Modules\Events\Enums;

enum ScheduleDisplay: string
{
    case HIDDEN = 'hidden';
    case DATE = 'date';
    case DATE_TIME = 'date_time';

    public static function fromValue(?string $value, bool $legacyPreview = false): self
    {
        return self::tryFrom($value) ?? ($legacyPreview ? self::DATE : self::DATE_TIME);
    }

    public function showsDateComponent(): bool
    {
        return $this !== self::HIDDEN;
    }

    public function showsTimeComponent(): bool
    {
        return $this === self::DATE_TIME;
    }
}
