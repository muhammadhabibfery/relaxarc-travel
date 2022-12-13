<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalTravelPackages = CountOfAllTravelPackages();
        $totalTransactions = CountOfAllTransactions();
        $totalInCartTransactions = countOfTransactionStatus('IN CART');
        $totalPendingTransactions = countOfTransactionStatus('PENDING');
        $totalSuccessTransactions = countOfTransactionStatus('SUCCESS');
        $totalFailedTransactions = countOfTransactionStatus('FAILED');

        return view('pages.backend.dashboard', compact('totalTravelPackages', 'totalTransactions', 'totalInCartTransactions', 'totalPendingTransactions', 'totalSuccessTransactions',  'totalFailedTransactions'));
    }
}
