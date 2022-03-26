<?php

namespace App\View\Components\Event;

use App\Models\Event;
use Illuminate\View\Component;

class Row extends Component
{
    public $event;
    public string $date;
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
            $this->date = $event->start_date->tz('Europe/Berlin')->format('d.m. H:i');
        }

        $attendance = $event->extras['attendance_mode'] ?? Event::ATTENDANCE_OFFLINE;

        switch ($attendance) {
            case Event::ATTENDANCE_MIXED:
                $this->attendance = 'Hybrid';
            case Event::ATTENDANCE_OFFLINE:
                $this->attendance = 'In Präsenz';
            case Event::ATTENDANCE_ONLINE:
                $this->attendance = 'Online';
        }

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
