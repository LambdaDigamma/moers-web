<?php

namespace App\View\Components\Event;

use App\Models\Event;
use App\Services\AttendanceModeFormatter;
use App\Services\EventDateFormatter;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class Row extends Component
{
    public $event;
    public string $date = "";
    public string $attendance;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
        
        if ($event->isActive()) {
            $this->date = "läuft gerade";
        } else {
            $this->date = EventDateFormatter::format($event->start_date, $event->end_date);
        }

        $this->attendance = AttendanceModeFormatter::format($event->extras['attendance_mode'] ?? null);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event.row');
    }
}
