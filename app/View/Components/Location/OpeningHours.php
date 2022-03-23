<?php

namespace App\View\Components\Location;

use Illuminate\View\Component;

class OpeningHours extends Component
{
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = [
            [
                'description' => 'Mo-Fr',
                'time' => '08:00-18:00'
            ],
            [
                'description' => 'Sa',
                'time' => '10:00-18:00'
            ]
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.location.opening-hours');
    }
}
