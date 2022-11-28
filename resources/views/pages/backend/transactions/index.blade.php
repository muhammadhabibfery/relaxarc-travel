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

        <!-- Mobile Searchbar -->
        <div class="col-sm-12 d-sm-block d-md-none">
            <form action="{{ route('transactions.index') }}" method="GET">
                <div class="form-group">
                    <label for="keyword" class="sr-only"></label>
                    <input type="text" name="keyword" class="form-control w-100" id="keyword"
                        placeholder="{{ __('Search by status / travel packages') }}" value="{{ request()->keyword }}">
                </div>
                <div class="form-group mt-3">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block mx-2" type="submit" id="button-addon2">{{
                                __('Search') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('transactions.index') }}" class="btn btn-dark btn-block d-inline-block"
                                id="button-addon2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Desktop Searchbar -->
        <div class="col-md-11 d-none d-md-block">
            <form action="{{ route('transactions.index') }}" method="GET" class="form-inline">
                <label for="keyword" class="sr-only"></label>
                <input type="text" name="keyword" class="form-control w-50" id="keyword"
                    placeholder="{{ __('Search by status / travel packages') }}" value="{{ request()->keyword }}">
                <button class="btn btn-primary mx-2" type="submit" id="button-addon2">{{ __('Search') }}</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-dark d-inline-block"
                    id="button-addon2">Reset</a>
            </form>
        </div>

        <div class="col-md-11 my-4">
            @if (checkRoles(["ADMIN", "SUPERADMIN", 2], auth()->user()->roles))
            <a href="{{ route('transactions.trash') }}" class="btn btn-orange btn-block mt-3">{{
                __('Transactions deleted') }}</a>
            @endif
        </div>

        <div class="col-md-11">
            <div class="card mt-0">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">{{ __('Invoice number') }}</th>
                                    <th scope="col">{{ __('Travel packages') }}</th>
                                    <th scope="col">{{ __('Ordered by') }}</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                <tr>
                                    <th scope="row">{{ $transactions->currentPage() * 10 - 10 + $loop->iteration }}
                                    </th>
                                    <td>{{ $transaction->invoice_number }}</td>
                                    <td>{{ $transaction->travelPackage->title }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>@convertCurrency($transaction->total)</td>
                                    <td>
                                        <p class="@php
                                            if(in_array($transaction->status, ['CANCEL', 'FAILED'])){
                                                echo 'text-danger';
                                            }
                                            elseif ($transaction->status === 'PENDING') {
                                                echo 'text-orange';
                                            }
                                            elseif ($transaction->status === 'IN_CART') {
                                                echo 'text-primary';
                                            }
                                            else {
                                                echo 'text-success';
                                            }
                                        @endphp">
                                            {{ $transaction->status }}
                                        </p>
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction) }}"
                                            class="btn btn-success btn-sm my-1">Detail</a>
                                        <a href="{{ route('transactions.edit', $transaction) }}"
                                            class="btn btn-warning btn-sm my-1">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                            data-target="#deletetransaction{{ $transaction->invoice_number }}Modal">{{
                                            __('Delete') }}</a>
                                    </td>

                                    {{-- Delete Travel Package Modal --}}
                                    <div class="modal fade"
                                        id="deletetransaction{{ $transaction->invoice_number }}Modal" tabindex="-1"
                                        role="dialog" aria-labelledby="deletetransactionModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        {{ __('Delete Travel Package') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Are you sure want to delete :Data :TravelPackage :Name ?',
                                                        ['data' => 'transaksi', 'travelPackage' =>
                                                        $transaction->travelPackage->title, 'user' =>
                                                        $transaction->user->name]) }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <form action="{{ route('transactions.destroy', $transaction) }}"
                                                        method="POST" onsubmit="return submitted(this)" id="myfr">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-primary" id="btnfr">{{
                                                            __('Delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="font-weight-bold text-center text-monospace">
                                            {{ __('Transactions not available') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->withQueryString()->onEachSide(2)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
