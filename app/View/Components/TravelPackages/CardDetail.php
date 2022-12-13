<?php

namespace App\View\Components\TravelPackages;

use Illuminate\View\Component;

class CardDetail extends Component
{

    public $travelPackage, $invoiceNumber, $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($travelPackage, $invoiceNumber, $type)
    {
        $this->travelPackage = $travelPackage;
        $this->invoiceNumber = $invoiceNumber;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.travel-packages.card-detail');
    }
}
