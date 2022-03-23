<?php

namespace App\Http\Livewire;

use App\Services\NavigationLinkBuilder;
use LivewireUI\Modal\ModalComponent;

class NavigationPanel extends ModalComponent
{
    public string $appleMapsHref;
    public string $googleMapsHref;

    public function mount($lat, $lng)
    {
        $this->appleMapsHref = NavigationLinkBuilder::buildAppleMapsLink($lat, $lng);
        $this->googleMapsHref = NavigationLinkBuilder::buildGoogleMapsLink($lat, $lng);
    }

    public function render()
    {
        return view('livewire.navigation-panel');
    }
}
