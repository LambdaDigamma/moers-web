<?php

namespace App\View\Components\Petrol;

use Illuminate\View\Component;

class PetrolStationCard extends Component
{
    public $isOpen = false;
    public $name = "Kuster Energy";
    public $brand = "Kuster Energy";

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = "Kuster Energy", $brand = "Kuster Energy", $isOpen = true)
    {
        $this->isOpen = $isOpen; //rand(0,1) == 1;
        $this->name = $name;
        $this->brand = $brand;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.petrol.petrol-station-card');
    }
}
