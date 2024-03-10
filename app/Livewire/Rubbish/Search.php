<?php

namespace App\Livewire\Rubbish;

use Livewire\Component;
use Modules\Rubbish\Models\RubbishStreet;

class Search extends Component
{
    public ?string $search = null;
    public $streets = null;

    public function render()
    {
        $this->streets = RubbishStreet::query()
            ->current()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return view('livewire.rubbish.search');
    }
}
