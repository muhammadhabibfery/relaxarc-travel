<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function __construct()
    {
        if (request()->session()->has('guest-route')) request()->session()->forget('guest-route');
    }

    /**
     * Show the checkout
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.frontend.checkout');
    }

    /**
     * Show the checkout success
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        return view('pages.frontend.checkout-success');
    }
}
