<?php

namespace App\View\Components;

use Illuminate\View\Component;

use function Pest\Laravel\flushSession;

class Card extends Component
{
    public bool $fluid;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $fluid = false)
    {
        $this->fluid = $fluid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
