<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\TravelPackageService;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Traits\MidtransPayment;

class CheckoutController extends Controller
{
    use MidtransPayment;

    /**
     * The name of service instance
     *
     * @var App\Services\TravelPackageService
     */
    private $travelPackageService;

    /**
     * The name of repository instance
     *
     * @var App\Repositories\Transaction\TransactionRepository
     */
    private $transactionRepository;

    /**
     * Create a new service and repository instance.
     *
     * @return void
     */
    public function __construct(
        TravelPackageService $travelPackageService,
        TransactionRepositoryInterface $transactionRepositoryInterface
    ) {
        $this->travelPackageService = $travelPackageService;
        $this->transactionRepository = $transactionRepositoryInterface;
    }

    public function index(string $invoiceNumber)
    {
        $transaction = $this->getOneTransaction($invoiceNumber);

        return view('pages.frontend.checkout', compact('transaction'));
    }

    public function redirectTo(string $slug)
    {
        if (!auth()->check()) return redirect()->route('travel-packages.front.detail', $slug);

        return $this->proccess($slug);
    }

    /**
     * proccessing the data before redirect to checkout view
     *
     * @param  string $slug
     * @return mixed
     */
    public function proccess(string $slug)
    {
        $travelPackage = $this->travelPackageService->takeOneTravelPackage($slug);

        $data = [
            'user_id' => auth()->id(),
            'total' => $travelPackage->price,
            'invoice_number' => generateInvoiceNumber(),
            'status' => 'IN CART'
        ];

        return $this->checkProccess(
            function () use ($travelPackage, $data) {
                if (!$transaction = $travelPackage->transactions()->create($data))
                    throw new \Exception(trans('status.failed_create_new_transaction'));

                if (!$this->storeNewTransactioDetail($transaction, auth()->user()->username))
                    throw new \Exception(trans('status.failed_create_new_transaction_detail'));

                return $transaction->invoice_number;
            },
            true,
            'checkout.index'
        );
    }

    /**
     * create and store the data member related
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  string $invoiceNumber
     * @return mixed
     */
    public function create(UserRequest $request, string $invoiceNumber)
    {
        $transaction = $this->getOneTransaction($invoiceNumber);

        return $this->checkProccess(
            function () use ($transaction, $request) {
                if (!$this->storeNewTransactioDetail($transaction, $request->validated()['username']))
                    throw new \Exception(trans('status.failed_create_new_transaction_detail'));

                if (!$this->updateTransactionTotal($transaction, $transaction->travelPackage->price))
                    throw new \Exception(trans('status.failed_add_member'));

                return null;
            },
            true
        );
    }

    /**
     * remove and delete the data member related
     *
     * @param  string $invoiceNumber
     * @param  string $username
     * @return mixed
     */
    public function delete(string $invoiceNumber, string $username)
    {
        $transaction = $this->getOneTransaction($invoiceNumber);

        return $this->checkProccess(
            function () use ($transaction, $username) {
                if (!$this->deleteTransactionDetail($transaction, $username)) throw new \Exception(trans('status.failed_delete_member'));

                if (!$this->updateTransactionTotal($transaction, $transaction->travelPackage->price, false))
                    throw new \Exception(trans('status.failed_delete_member'));

                return null;
            },
            true
        );
    }

    /**
     * delete the transaction data that owns user cancel the checkout/payment
     *
     * @param  string $invoiceNumber
     * @return mixed
     */
    public function cancel(string $invoiceNumber)
    {
        $transaction = $this->getOneTransaction($invoiceNumber);
        $slug = $transaction->travelPackage->slug;

        return $this->checkProccess(
            function () use ($transaction, $slug) {
                if (!$this->deleteTransactionDetail($transaction)) throw new \Exception(trans('status.failed_cancel_payment'));

                if (!$transaction->forceDelete()) throw new \Exception(trans('status.failed_cancel_payment'));

                return $slug;
            },
            true,
            'travel-packages.front.detail'
        );
    }

    /**
     * Show the checkout success view
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        if (session()->has('guest-route')) session()->forget('guest-route');

        return view('pages.frontend.checkout-success');
    }

    /**
     * Show the checkout pending view
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        return view('pages.frontend.checkout-pending');
    }


    /**
     * Show the checkout failed view
     *
     * @return \Illuminate\Http\Response
     */
    public function failed()
    {
        return view('pages.frontend.checkout-failed');
    }

    /**
     * get the spesific a transaction by invoice number field
     *
     * @param  string $invoiceNumber
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getOneTransaction(string $invoiceNumber)
    {
        return $this->transactionRepository->findOneTransactionByInvoiceNumber($invoiceNumber)
            ->firstOrNotFound();
    }


    /**
     * store a new transaction detail
     *
     * @param  object $transaction
     * @param  string $username
     * @return bool
     */
    private function storeNewTransactioDetail(object $transaction, string $username)
    {
        return $transaction->transactionDetails()
            ->create(['username' => $username]);
    }

    /**
     * delete the transaction detail(s)
     *
     * @param  object $transaction
     * @param  string|null $username
     * @return mixed
     */
    private function deleteTransactionDetail(object $transaction, ?string $username = null)
    {
        $transactionDetails = $transaction->transactionDetails();

        if ($username) $transactionDetails->where('username', $username)->firstOrFail();

        return $transactionDetails->delete();
    }

    /**
     * update the total transaction
     *
     * @param  object $transaction
     * @param  int $price
     * @param  bool $plus
     * @return mixed
     */
    private function updateTransactionTotal(object $transaction, int $price, ?bool $plus = true)
    {
        $plus ? $transaction->total += $price : $transaction->total -= $price;

        return $transaction->save();
    }

    /**
     * Check one or more processes and catch them if fail
     *
     * @param  string|null $routeName
     * @param  callable $action
     * @param  bool $dbTransaction  use database transaction for multiple queries
     * @return \Illuminate\Http\Response
     */
    private function checkProccess(callable $action, ?bool $dbTransaction = false, ?string $routeName = null)
    {
        try {
            if ($dbTransaction) $this->transactionRepository->beginTransaction();

            $params = $action();

            if ($dbTransaction) $this->transactionRepository->commitTransaction();
        } catch (\Exception $e) {
            if ($dbTransaction) $this->transactionRepository->rollbackTransaction();

            return back()->with('failed', $e->getMessage());
        }

        if ($routeName && $params) return redirect()->route($routeName, $params);

        return $routeName ? redirect()->route($routeName) : back();
    }
}
