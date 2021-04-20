<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $transactions = $this->getTransactionWithParams($keyword);

        return view('pages.backend.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->generateInvoiceNumber();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('pages.backend.transactions.detail', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $status = ['IN_CART', 'PENDING', 'SUCCESS', 'CANCEL', 'FAILED'];
        return view('pages.backend.transactions.edit', compact('transaction', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $data = array_merge(
            $request->validated(),
            ['updated_by' => auth()->id()]
        );

        $transaction->update($data);

        return redirect()->route('transactions.index')
            ->with('status', trans('status.update_transaction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->update(['deleted_by' => auth()->id()]);
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('status', trans('status.delete_transaction'));
    }

    public function trash(Request $request)
    {
        $keyword = $request->keyword;
        $deletedTransactions = $this->getTransactionWithParams($keyword, true);

        return view('pages.backend.transactions.trash', compact('deletedTransactions'));
    }

    public function restore(Request $request)
    {
        $transactionRestore = $this->getTransactionTrashedWithSlug($request->invoice_number);
        $transactionRestore->update(['deleted_by' => null]);
        $transactionRestore->restore();

        return redirect()->route('transactions.index')
            ->with('status', trans('status.restore_transaction', ['transaction' => $transactionRestore->invoice_number]));
    }

    public function forceDelete(Request $request)
    {
        $transactionDelete = $this->getTransactionTrashedWithSlug($request->invoice_number);
        $invoiceNumber = $transactionDelete->invoice_number;
        $transactionDelete->forceDelete();

        return redirect()->route('transactions.trash')
            ->with('status', trans('status.delete_permanent_transaction', ['transaction' => $invoiceNumber]));
    }

    private function getTransactionWithParams($keyword, $trashed = false)
    {
        if ($trashed) {
            return Transaction::onlyTrashed()
                ->with([
                    'travelPackage' => function ($query) {
                        $query->select('id', 'title', 'slug');
                    },
                    'user' => function ($query) {
                        $query->select('id', 'name', 'username');
                    }
                ])
                ->withCount('transactionDetails')
                ->where(function ($query) use ($keyword) {
                    $query->where('status', 'LIKE', "%$keyword%")
                        ->orWhereHas('travelPackage', function (Builder $query) use ($keyword) {
                            $query->where('title', 'LIKE', "%$keyword%");
                        });
                })
                ->latest()
                ->paginate(10);
        }

        return Transaction::with([
            'travelPackage' => function ($query) {
                $query->select('id', 'title', 'slug');
            },
            'user' => function ($query) {
                $query->select('id', 'name', 'username');
            }
        ])
            ->where(function ($query) use ($keyword) {
                $query->where('status', 'LIKE', "%$keyword%")
                    ->orWhereHas('travelPackage', function (Builder $query) use ($keyword) {
                        $query->where('title', 'LIKE', "%$keyword%");
                    });
            })
            ->latest()
            ->paginate(10);
    }

    private function getTransactionTrashedWithSlug($invoiceNumber)
    {
        return Transaction::onlyTrashed()
            ->where('invoice_number', $invoiceNumber)
            ->firstOrFail();
    }

    private function generateInvoiceNumber()
    {
        return "RelaxArc-" . date('djy') . Str::random(16);
    }
}
