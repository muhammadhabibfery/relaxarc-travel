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
                            <td>@convertCurrency($transaction->total)</td>
                            <td>
                                <p class="@php
                                            if(in_array($transaction->status, ['CANCEL', 'FAILED'])){
                                                echo 'text-danger';
                                            }
                                            elseif ($transaction->status === 'PENDING') {
                                                echo 'text-orange';
                                            }
                                            elseif ($transaction->status === 'IN CART') {
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
                                @if ($file == 'index')
                                <a href="{{ route('transactions.show', $transaction) }}"
                                    class="btn btn-success btn-sm my-1">Detail</a>
                                <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                    data-target="#deletetransaction{{ $transaction->invoice_number }}Modal">{{
                                    __('Delete') }}</a>
                                @else
                                <a href="{{ route('transactions.trash.show', $transaction->invoice_number) }}"
                                    class="btn btn-success btn-sm my-1">Detail</a>
                                <a href="{{ route('transactions.restore', $transaction->invoice_number) }}"
                                    class="btn btn-warning btn-sm my-1"
                                    onclick="return confirm('{{ __('Are you sure want to restore transaction ?') }}')">{{
                                    __('Restore') }}</a>
                                <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                    data-target="#deletetransaction{{ $transaction->invoice_number }}Modal">{{
                                    __('Delete permanently') }}</a>
                                @endif
                            </td>

                            {{-- Delete Transaction Modal --}}
                            <div class="modal fade" id="deletetransaction{{ $transaction->invoice_number }}Modal"
                                tabindex="-1" role="dialog" aria-labelledby="deletetransactionModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                {{ __('Delete Transaction') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                @if ($file == 'index')
                                                {{ __('Are you sure want to delete transaction ?') }}
                                                @else
                                                {{ __('Are you sure want to delete transaction permanently ?',
                                                ['invoice_number' => $transaction->invoice_numbe]) }}
                                                @endif
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{
                                                __('Cancel') }}</button>
                                            <form @if ($file=='index' )
                                                action="{{ route('transactions.destroy', $transaction) }}" @else
                                                action="{{ route('transactions.force-delete', $transaction->invoice_number) }}"
                                                @endif method="POST" onsubmit="return submitted(this)" id="myfr">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-primary" id="btnfr">
                                                    {{ $file == 'index' ? __('Delete') : __('Delete permanently') }}
                                                </button>
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
