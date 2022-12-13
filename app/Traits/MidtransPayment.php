<?php

namespace App\Traits;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\Checkout\TransactionSuccess;

trait MidtransPayment
{

    /**
     * the name of available payments
     *
     * @var array
     */
    public $availablePayments = ['bri_va', 'bni_va', 'gopay', 'shopeepay'];

    /**
     * set midtrans configuration
     *
     * @return void
     */
    private function configuration()
    {
        Config::$serverKey = config('Midtrans.midtrans_serverkey');
        Config::$isProduction = config('Midtrans.midtrans_production');
        Config::$isSanitized = config('Midtrans.midtrans_sanitized');
        Config::$is3ds = config('Midtrans.midtrans_3ds');
    }

    /**
     * set parameter for payment credentials
     *
     * @param  object $transaction
     * @return array
     */
    private function setParams(object $transaction)
    {
        return [
            'transaction_details' => ['order_id' => $transaction->invoice_number, 'gross_amount' => (int) $transaction->total],
            'customer_details' => ['first_name' => $transaction->user->name, 'email' => $transaction->user->email],
            'enabled_payments' => $this->availablePayments,
            'vtweb' => []
        ];
    }

    /**
     * send payment credentials to snap backend (midtrans api)
     *
     * @param  string $invoiceNumber
     * @return mixed
     */
    public function sendPaymentCredentials(string $invoiceNumber)
    {
        $transaction = $this->getOneTransaction($invoiceNumber);

        $this->configuration();

        try {
            return redirect(Snap::createTransaction($this->setParams($transaction))->redirect_url);
        } catch (\Exception $e) {
            if (str_contains(response()->json($e->getMessage())->getData(), '400'))
                return redirect()->route('travel-packages.front.detail', $transaction->travelPackage->slug)
                    ->with('failed', 'something went wrong');

            return $e->getMessage();
        }
    }

    /**
     * handle data from midtrans
     *
     * @param  object|null $data
     * @return mixed
     */
    public function notificationHandler(?object $data = null)
    {

        [$transactionStatus, $transaction] = $this->setDataFromMidtrans($data);

        if (!auth()->check()) auth()->login($transaction->user);

        if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $transaction->status = 'FAILED';
            $routeName = 'checkout.failed';
        }
        if ($transactionStatus === 'pending') {
            $transaction->status = 'PENDING';
            $routeName = 'checkout.pending';
        }
        if ($transactionStatus === 'settlement') {
            $transaction->status = 'SUCCESS';
            $routeName = 'checkout.success';
            Mail::to($transaction->user)->send(new TransactionSuccess($transaction));
        }

        return $this->checkProccess(
            function () use ($transaction) {
                if (!$transaction->save()) {
                    $transaction->delete();
                    return redirect()->route('travel-packages.front.index')
                        ->with(trans('The payment failed to process, Please try again'));
                }

                return null;
            },
            false,
            $routeName
        );
    }

    /**
     * finish redirect url (set via snap setting or midtrans dashboard)
     *
     * @return mixed
     */
    public function finish()
    {
        return $this->notificationHandler(request());
    }

    /**
     * unfinish redirect url (set via snap setting or midtrans dashboard)
     *
     * @return mixed
     */
    public function unfinish()
    {
        return $this->notificationHandler(request());
    }

    /**
     * error redirect url (set via snap setting or midtrans dashboard)
     *
     * @return mixed
     */
    public function error()
    {
        return $this->notificationHandler(request());
    }

    /**
     * set data from midtrans
     *
     * @param  object|null $data
     * @return mixed
     */
    private function setDataFromMidtrans(?object $data = null)
    {
        $this->configuration();

        if ($data && $data->transaction_status) {
            $notification = $data;
        } else {
            if (request()->payment_type) {
                try {
                    $notification = new Notification();
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Interal Server Error',
                        'data' => []
                    ]);
                }
            } else {
                return redirect()->route('travel-packages.front.index');
            };
        }

        return [$notification->transaction_status, $this->getOneTransaction($notification->order_id)];
    }
}
