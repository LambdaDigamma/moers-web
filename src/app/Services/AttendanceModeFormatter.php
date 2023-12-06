<?php

namespace App\Services;

use App\Models\Event;

class AttendanceModeFormatter
{
    public static function format(?string $attendanceMode): string
    {
        switch ($attendanceMode ?? Event::ATTENDANCE_OFFLINE) {
            case Event::ATTENDANCE_MIXED:
                return __('events.attendance_mixed');
            case Event::ATTENDANCE_OFFLINE:
                return __('events.attendance_offline');
            case Event::ATTENDANCE_ONLINE:
                return __('events.attendance_online');
            default:
                return __('events.attendance_offline');
        }
    }
}