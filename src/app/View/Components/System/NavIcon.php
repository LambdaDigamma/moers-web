<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class NavIcon extends Component 
{
    public string $route;
    public string $title;
    public string $href;
    public bool $active = false; 
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $route, string $title)
    {
        $this->route = $route;
        $this->title = $title;
        $this->href = route($route);
        $this->active = request()->route()->getName() == $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.system.nav-icon');
    }

}