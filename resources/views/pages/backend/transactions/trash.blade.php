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

        <!-- Mobile Searchbar -->
        <div class="col-sm-12 d-sm-block d-md-none">
            <form action="{{ route('transactions.trash') }}" method="GET">
                <div class="form-group">
                    <label for="keyword" class="sr-only"></label>
                    <input type="text" name="keyword" class="form-control w-100" id="keyword"
                        placeholder="{{ __('Search by title / location') }}" value="{{ request()->keyword }}">
                </div>
                <div class="form-group mt-3">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block mx-2" type="submit"
                                id="button-addon2">{{ __('Search') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('transactions.trash') }}" class="btn btn-dark btn-block d-inline-block"
                                id="button-addon2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
            <a href="{{ route('transactions.index') }}" class="btn btn-block btn-secondary my-3">{{ __('Back') }}</a>
        </div>

        <!-- Desktop Searchbar -->
        <div class="col-md-11 d-none d-md-block mb-3">
            <div class="row">
                <div class="col-md-10">
                    <form action="{{ route('transactions.trash') }}" method="GET" class="form-inline">
                        <label for="keyword" class="sr-only"></label>
                        <input type="text" name="keyword" class="form-control w-50" id="keyword"
                            placeholder="{{ __('Search by title or location') }}" value="{{ request()->keyword }}">
                        <button class="btn btn-primary mx-2" type="submit"
                            id="button-addon2">{{ __('Search') }}</button>
                        <a href="{{ route('transactions.trash') }}" class="btn btn-dark d-inline-block"
                            id="button-addon2">Reset</a>
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="float-md-right">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">{{ __('Invoice number') }}</th>
                                    <th scope="col">{{ __('Travel packages') }}</th>
                                    <th scope="col">{{ __('Ordered by') }}</th>
                                    <th scope="col">{{ __('Number of buyers') }}</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedTransactions as $deletedTransaction)
                                <tr>
                                    <th scope="row">
                                        {{ $deletedTransactions->currentPage() * 10 - 10 + $loop->iteration }}
                                    </th>
                                    <td>{{ $deletedTransaction->invoice_number }}</td>
                                    <td>{{ $deletedTransaction->travelPackage->title }}</td>
                                    <td>{{ $deletedTransaction->user->name }}</td>
                                    <td>
                                        {{ __(':count person', ['count' => $deletedTransaction->transaction_details_count]) }}
                                    </td>
                                    <td>@convertCurrency($deletedTransaction->total)</td>
                                    <td>
                                        <p class="@php
                                            if(in_array($deletedTransaction->status, ['CANCEL', 'FAILED'])){
                                                echo 'text-danger';
                                            }
                                            elseif ($deletedTransaction->status === 'PENDING') {
                                                echo 'text-orange';
                                            }
                                            elseif ($deletedTransaction->status === 'IN_CART') {
                                                echo 'text-primary';
                                            }
                                            else {
                                                echo 'text-success';
                                            }
                                        @endphp">
                                            {{ $deletedTransaction->status }}
                                        </p>
                                    </td>
                                    <td>
                                        <a href="{{ route('transactions.restore', $deletedTransaction->invoice_number) }}"
                                            class="btn btn-warning btn-sm my-1"
                                            onclick="return confirm('{{ __('Are you sure want to restore transaction :invoice_number ?', ['invoice_number' => $deletedTransaction->invoice_number]) }}')">{{ __('Restore') }}</a>
                                        <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                            data-target="#deletetransaction{{ $deletedTransaction->invoice_number }}Modal">{{ __('Delete permanently') }}</a>
                                    </td>

                                    {{-- Delete Transaction Modal --}}
                                    <div class="modal fade"
                                        id="deletetransaction{{ $deletedTransaction->invoice_number }}Modal"
                                        tabindex="-1" role="dialog" aria-labelledby="deletetransactionModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        {{ __('Delete Transaction') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{ __('Are you sure want to delete permanently transaction ?', ['invoice_number' => $deletedTransaction->invoice_number]) }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <form
                                                        action="{{ route('transactions.force-delete', $deletedTransaction->invoice_number) }}"
                                                        method="POST" onsubmit="return submitted(this)" id="myfr">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-primary"
                                                            id="btnfr">{{ __('Delete permanently') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="font-weight-bold text-center text-monospace">
                                            {{ __('Transactions deleted not available') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $deletedTransactions->withQueryString()->onEachSide(2)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
