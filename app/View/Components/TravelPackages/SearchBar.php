<?php

namespace App\View\Components\TravelPackages;

use Illuminate\View\Component;

class SearchBar extends Component
{

    public $file, $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($file, $route)
    {
        $this->file = $file;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.travel-packages.search-bar');
    }
}
