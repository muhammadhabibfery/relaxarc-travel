<?php

namespace App\View\Components\Transactions;

use Illuminate\View\Component;

class TransactionListTable extends Component
{

    public $file, $transactions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($file, $transactions)
    {
        $this->file = $file;
        $this->transactions = $transactions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.transactions.transaction-list-table');
    }
}
