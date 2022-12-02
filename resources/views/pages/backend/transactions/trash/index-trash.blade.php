@extends('layouts.backend.master-backend')

@section('title', 'Transactions deleted')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Transactions deleted') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile or Desktop Searchbar -->
        <x-transactions.search-bar :route="route('transactions.trash')" file='trash' />

        <!-- list of transactions table -->
        <x-transactions.transaction-list-table :transactions="$deletedTransactions" file="trash" />

    </div>
</div>
@endsection

@push('addon_links')
@include('pages.backend.travel-packages.includes._select2-style')
@endpush

@push('addon_scripts')
@include('pages.backend.travel-packages.includes._select2-script')
@endpush
