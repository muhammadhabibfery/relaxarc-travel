<?php

namespace App\View\Components\TravelPackages;

use Illuminate\View\Component;

class ListData extends Component
{

    public $data;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.travel-packages.list-data', ['data' => $this->formatData($this->data)]);
    }

    /**
     * transform Data To Array Or String
     *
     * @param  string $data
     * @return array|string
     */
    public function formatData($data)
    {
        return is_array($data)
            ? array_filter($data, fn ($value) => !empty($value) && $value != " ")
            : $data;
    }
}
