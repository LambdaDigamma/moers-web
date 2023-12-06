<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class Main extends Component
{
    public $hide = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $hide = false)
    {
        $this->hide = $hide;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.main');
    }
}
