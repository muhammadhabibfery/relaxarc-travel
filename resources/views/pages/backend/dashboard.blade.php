@extends('layouts.backend.master-backend')

@section('title', 'RelaxArc Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Travel Package Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ __('Travel packages') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ numberOfTravelPackages() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hotel fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{ __('Transactions') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ numberOfTransactions() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cash-register fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Checkout Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Checkout Pending
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ numberOfPendingTransactions() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Checkout Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                {{ __('Checkout Success') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold fa-3x text-gray-800">
                                {{ numberOfSuccessfulTransactions() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
