@extends('layouts.backend.master-backend')

@section('title', 'Detail Travel Packages')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Detail transaction') }}</h1>
        <a href="{{ route('transactions.index') }}"
            class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back') }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                        {{ __('Detail Transaction (:TravelPackage, :Name)', ['travelPackage' => $transaction->travelPackage->title, 'name' => $transaction->user->name]) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tr>
                                <th>{{ __('Invoice number') }}</th>
                                <td>{{ $transaction->invoice_number }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Travel packages') }}</th>
                                <td>{{ $transaction->travelPackage->title }}</td>
                            </tr>
                            <tr>
                            <tr>
                                <th>{{ __('Ordered by') }}</th>
                                <td>{{ $transaction->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>@convertCurrency($transaction->total)</td>
                            </tr>
                            <tr>
                                <th>Status</th>
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
                            </tr>
                            <tr>
                                <th>{{ __('Number of buyers') }}</th>
                                <td>
                                    <ul>
                                        @foreach ($transaction->transactionDetails as $detail)
                                        <li>{{ $detail->username }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <small class="text-muted">
                        {{ __('Created by :Username', ['username' => createdUpdatedDeletedBy($transaction->created_by)->username ?? '-']) }}
                    </small>
                    <small class="text-muted float-md-right d-block d-md-inline-block d-lg-inline-block">
                        @if ($transaction->updated_by)
                        {{ __('Last updated by :Name (:Date)', ['name' => createdUpdatedDeletedBy($transaction->updated_by)->username, 'date' => $transaction->updated_at ? $transaction->updated_at->diffForHumans() : now()]) }}
                        @else
                        {{ __('Last updated :Date', ['date' => $transaction->updated_at ? $transaction->updated_at->diffForHumans() : now()]) }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
