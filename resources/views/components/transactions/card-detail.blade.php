<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ __('Detail transaction') }}</h1>
    <a href="{{ $route }}" class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back') }}</a>
</div>

<!-- Content Row -->
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card">
            <div class="card-header">
                <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                    {{ __('Detail Transaction travel package :TravelPackage', ['travelPackage' =>
                    $transaction->travelPackage->title]) }}
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
                            <td>
                                <a href="{{ route('travel-packages.show', [$transaction->travelPackage->slug, $transaction->invoice_number]) }}"
                                    class="text-bold text-dark-blue text-decoration-none">
                                    {{ $transaction->travelPackage->title }}
                                </a>
                            </td>
                            {{-- <td>{{ $transaction->travelPackage->title }}</td> --}}
                        </tr>
                        <tr>
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
                            <td>{{ $transaction->transaction_details_count }}</td>
                        </tr>
                        <tr>
                            <th class="align-middle">{{ __('Detail of buyers') }}</th>
                            <td>
                                <div class="list-group list-group-flush">
                                    @foreach ($transaction->transactionDetails as $detail)
                                    <a href="{{ route('detail-profile', [$detail->username, $transaction->invoice_number]) }}"
                                        class="list-group-item list-group-item-action text-dark">
                                        {{ $detail->username }}
                                    </a>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>@convertCurrency($transaction->total)</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                <small class="text-muted">
                    {{ __('Ordered by :Name', ['Name' =>
                    createdUpdatedDeletedBy($transaction->user_id)->name ?? '-']) }}
                </small>
                <small class="text-muted float-md-right d-block d-md-inline-block d-lg-inline-block">
                    @if ($transaction->deleted_by)
                    {{ __('Deleted by :Name (:Date)',
                    ['Name' => createdUpdatedDeletedBy($transaction->deleted_by)->name,
                    'date' => $transaction->deleted_at->diffForHumans()]) }}
                    @elseif($transaction->updated_by)
                    {{ __('Last updated by :Name (:Date)',
                    ['Name' => createdUpdatedDeletedBy($transaction->updated_by)->name,
                    'date'=> $transaction->updated_at->diffForHumans()]) }}
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>
