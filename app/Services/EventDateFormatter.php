<?php

namespace App\Services;

use App\View\Components\Card;
use Illuminate\Support\Carbon;

class EventDateFormatter
{
    public static function format(?Carbon $start, ?Carbon $end = null): string
    {
        $start = $start?->tz('Europe/Berlin');
        $end = $end?->tz('Europe/Berlin');

        if ($start && $end) {
            if ($start->isSameDay($end)) {
                return self::formatRelative($start) . '-' . $end->tz('Europe/Berlin')->format('H:i');
            } else {
                return self::formatRelative($start) . ' - ' . $end->tz('Europe/Berlin')->format('d.m. H:i');
            }
        } else if ($start) {
            return self::formatRelative($start);
        } else {
            return __('Unknown');
        }
    }

    private static function formatRelative(Carbon $date): string
    {
        $date = $date->tz('Europe/Berlin')->locale('de_DE');
        if ($date->isToday()) {
            return __('Today') . ', ' . $date->format('H:i');
        } else if ($date->isTomorrow()) {
            return __('Tomorrow') . ', ' . $date->format('H:i');
        }
        return $date->isoFormat('dd, DD.MM. HH:mm');
    }
}