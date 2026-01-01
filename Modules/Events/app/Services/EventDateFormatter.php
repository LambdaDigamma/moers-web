<?php

namespace Modules\Events\Services;

use Illuminate\Support\Carbon;

class EventDateFormatter
{
    public static function format(Carbon|\Carbon\Carbon|null $start, Carbon|\Carbon\Carbon|null $end = null): string
    {
        $timezone = 'Europe/Berlin';
        $start = $start?->tz($timezone);
        $end = $end?->tz($timezone);

        if ($start && $end) {
            if ($start->isSameDay($end)) {
                return self::formatRelative($start).'-'.$end->tz($timezone)->format('H:i');
            } else {
                return self::formatRelative($start).' - '.$end->tz($timezone)->format('d.m. H:i');
            }
        } elseif ($start) {
            return self::formatRelative($start);
        } else {
            return __('Unknown');
        }
    }

    private static function formatRelative(Carbon $date): string
    {
        $timezone = 'Europe/Berlin';
        $date = $date->tz($timezone)->locale('de_DE');
        if ($date->isToday()) {
            return __('Today').', '.$date->format('H:i');
        } elseif ($date->isTomorrow()) {
            return __('Tomorrow').', '.$date->format('H:i');
        }

        return $date->isoFormat('dd, DD.MM. HH:mm');
    }
}
