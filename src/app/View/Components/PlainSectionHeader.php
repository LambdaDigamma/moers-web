<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PlainSectionHeader extends Component
{
    public $hideBorder = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $hideBorder = false)
    {
        $this->hideBorder = $hideBorder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.plain-section-header');
    }
}
