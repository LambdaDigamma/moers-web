<?php

namespace App\Http\Livewire\Rubbish;

use App\Models\RubbishStreet;
use Livewire\Component;

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
