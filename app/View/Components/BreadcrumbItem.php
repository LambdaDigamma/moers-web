<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BreadcrumbItem extends Component
{
    public $href = '#';
    public bool $current = false;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href = '#', bool $current = false)
    {
        $this->href = $href;
        $this->current = $current;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.breadcrumb-item');
    }
}
