<?php

namespace App\View\Components\Parking;

use App\Models\ParkingArea;
use Illuminate\View\Component;

class Panel extends Component
{
    public $parkingArea;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ParkingArea $parkingArea)
    {
        $this->parkingArea = $parkingArea;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.parking.panel');
    }
}
