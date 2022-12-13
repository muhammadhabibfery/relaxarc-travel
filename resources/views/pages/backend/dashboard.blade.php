@extends('layouts.backend.master-backend')

@section('title', 'RelaxArc Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-around">

        <div class="col-xl-4 col-md-4">
            <div class="row">
                <!-- Travel Package Card -->
                <div class="col-12 mb-3 mb-lg-5 mb-md-5">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <a href="{{ route('travel-packages.index') }}" class="text-decoration-none">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            {{ __('Travel packages') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTravelPackages }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-hotel fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Transactions Card -->
                <div class="col-12 mt-lg-4 mt-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <a href="{{ route('transactions.index') }}" class="text-decoration-none">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            {{ __('Transactions') }}
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransactions }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-cash-register fa-3x"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6">
            <!-- Detail of Transaction Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Transaction Status') }}</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold mb-4">{{ __('Transactions') }} IN CART
                        <span class="float-right">{{ $totalInCartTransactions }}</span>
                    </h4>
                    <h4 class="small font-weight-bold mb-4">{{ __('Transactions') }} PENDING
                        <span class="float-right">{{ $totalPendingTransactions }}</span>
                    </h4>
                    <h4 class="small font-weight-bold mb-4">{{ __('Transactions') }} SUCCESS
                        <span class="float-right">{{ $totalSuccessTransactions }}</span>
                    </h4>
                    <h4 class="small font-weight-bold mb-4">{{ __('Transactions') }} FAILED
                        <span class="float-right">{{ $totalFailedTransactions }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
