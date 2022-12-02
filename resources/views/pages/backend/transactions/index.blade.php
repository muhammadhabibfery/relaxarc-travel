@extends('layouts.backend.master-backend')

@section('title', 'Manage transactions')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Manage transactions') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile or Desktop Searchbar -->
        <x-transactions.search-bar :route="route('transactions.index')" file='index' />

        <div class="col-md-11 my-4">
            @if (checkRoles(["ADMIN", "SUPERADMIN", 2], auth()->user()->roles))
            <a href="{{ route('transactions.trash') }}" class="btn btn-orange btn-block mt-3">{{
                __('Transactions deleted') }}</a>
            @endif
        </div>

        <!-- list of transactions table -->
        <x-transactions.transaction-list-table :transactions="$transactions" file="index" />

    </div>
</div>
@endsection

@push('addon_links')
@include('pages.backend.travel-packages.includes._select2-style')
@endpush

@push('addon_scripts')
@include('pages.backend.travel-packages.includes._select2-script')
@endpush
