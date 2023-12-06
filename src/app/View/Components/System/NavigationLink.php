<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class NavigationLink extends Component
{
    public string $route;
    public string $href;
    public bool $active = false; 
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $route)
    {
        $this->route = $route;
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
        return view('components.system.navigation-link');
    }
}
