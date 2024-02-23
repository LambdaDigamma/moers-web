<?php

namespace App\View\Components\Home;

use Illuminate\View\Component;

class CategoryItem extends Component
{
    public string $href = "#";
    public string $title;
    public bool $topLeft;
    public bool $topRight;
    public bool $bottomLeft;
    public bool $bottomRight;
    public string $cornerClass = "";

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param string $href
     * @param bool   $topLeft
     * @param bool   $topRight
     * @param bool   $bottomLeft
     * @param bool   $bottomRight
     */
    public function __construct(
        string $title,
        string $href = "#",
        bool $topLeft = false,
        bool $topRight = false,
        bool $bottomLeft = false,
        bool $bottomRight = false
    )
    {
        $this->title = $title;
        $this->href = $href;
        $this->topLeft = $topLeft;
        $this->topRight = $topRight;
        $this->bottomLeft = $bottomLeft;
        $this->bottomRight = $bottomRight;

        if ($topLeft) {
            $this->cornerClass = "rounded-tl-lg rounded-tr-lg sm:rounded-tr-none";
        } elseif ($topRight) {
            $this->cornerClass = "sm:rounded-tr-lg";
        } elseif ($bottomLeft) {
            $this->cornerClass = "sm:rounded-bl-lg";
        } elseif ($bottomRight) {
            $this->cornerClass = "rounded-bl-lg rounded-br-lg sm:rounded-bl-none";
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.home.category-item');
    }
}
