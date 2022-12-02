@extends('layouts.backend.master-backend')

@section('title', 'Edit Transaction')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Transaction') }}</h1>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back')
            }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-0">
                <div class="card-body">
                    <form action="{{ route('transactions.update', $transaction) }}" method="POST" id="myfr"
                        onsubmit="return submitted(this)">
                        @csrf
                        @method('patch')
                        <div class=" form-group">
                            <label for="invoice_number">{{ __('Invoice Number') }}</label>
                            <input type="text" name="invoice_number" class="form-control" id="invoice_number"
                                value="{{ $transaction->invoice_number }}" disabled>
                        </div>
                        <div class=" form-group">
                            <label for="travel_package">{{ __('Travel packages') }}</label>
                            <input type="text" name="travel_package" class="form-control" id="travel_package"
                                value="{{ $transaction->travelPackage->title }}" disabled>
                        </div>
                        <div class=" form-group">
                            <label for="user">
                                <a href="#collapseOrder" class="text-decoration-none text-dark"
                                    data-toggle="collapse">{{
                                    __('Detail of buyers') }} &#8628;</a>
                            </label>
                            <div class="list-group list-group-flush collapse" id="collapseOrder">
                                @foreach ($transaction->transactionDetails as $detail)
                                <div class="list-group-item list-group-item-action bg-light text-dark">
                                    {{ $detail->username }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class=" form-group">
                            <label for="total">Total</label>
                            <input type="text" name="total" class="form-control" id="total"
                                value="@convertCurrency($transaction->total)" disabled>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror"
                                id="status">
                                @foreach ($status as $s)
                                <option value="{{ $s }}" {{ old('status', $transaction->status) === $s ? 'selected' : ''
                                    }}>
                                    {{ $s }}
                                </option>
                                @endforeach
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-block btn-primary" id="btnfr">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
