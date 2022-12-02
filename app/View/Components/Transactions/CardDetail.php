<?php

namespace App\View\Components\Transactions;

use Illuminate\View\Component;

class CardDetail extends Component
{

    public $transaction, $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($transaction, $route)
    {
        $this->transaction = $transaction;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transactions.card-detail');
    }
}
