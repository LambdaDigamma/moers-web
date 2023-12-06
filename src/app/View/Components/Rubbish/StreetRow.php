<?php

namespace App\View\Components\Rubbish;

use App\Models\RubbishStreet;
use Illuminate\View\Component;

class StreetRow extends Component
{
    public ?string $title = "";
    public ?string $subtitle = "";
    public int $street_id;

    /**
     * Create a new component instance.
     *
     * @param \App\Models\RubbishStreet $street
     */
    public function __construct(RubbishStreet $street)
    {
        $this->title = $street->name;
        $this->street_id = $street->id;

        if (! is_null($street->street_addition) && $street->street_addition != '')
        {
            $this->subtitle = $street->street_addition;
        }

        $this->subtitle = "kein Zusatz";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.rubbish.street-row');
    }
}
