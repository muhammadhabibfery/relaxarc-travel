<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.frontend.checkout');
    }

    public function success(Request $request)
    {
        return view('pages.frontend.checkout-success');
    }
}
