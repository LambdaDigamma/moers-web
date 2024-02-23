<?php

namespace App\View\Components\Event;

use Illuminate\View\Component;

class CategoryChip extends Component
{
    public $image;
    public $text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $image, string $text)
    {
        $this->image = $image;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event.category-chip');
    }
}
