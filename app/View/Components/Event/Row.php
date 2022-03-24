<?php

namespace App\View\Components\Event;

use App\Models\Event;
use Illuminate\View\Component;

class Row extends Component
{
    public $event;
    public string $date;

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
