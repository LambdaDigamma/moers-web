<?php

namespace App\View\Components\Location;

use Illuminate\View\Component;

class OpeningState extends Component
{
    public string $state;

    public const UNKNOWN = "unknown";
    public const OPEN = "open";
    public const CLOSED = "closed";
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $state)
    {
        $this->state = $state;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.location.opening-state');
    }
}
