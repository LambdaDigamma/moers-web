<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class ParkingOverview extends Component
{
    public $parkingAreas;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parkingAreas)
    {
        $this->parkingAreas = $parkingAreas;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.parking-overview');
    }
}
