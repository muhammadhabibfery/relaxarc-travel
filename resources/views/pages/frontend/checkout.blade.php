@extends('layouts.frontend.master-checkout')

@section('title', 'checkout')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content mb-5">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="row">
                <div class="col pl-lg-0">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Paket Travel
                            </li>
                            <li class="breadcrumb-item">
                                Detail
                            </li>
                            <li class="breadcrumb-item active">
                                Checkout
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- End Breadcrumb -->

            <!-- Checkout -->
            <div class="row">
                <div class="col-lg-8 pl-lg-0 mb-3 mb-lg-0">
                    <div class="card card-detail">
                        <h1>Who is Going?</h1>
                        <p>{{ $transaction->travelPackage->title }} ({{ $transaction->travelPackage->location }})</p>

                        <div class="attende">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Username</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction->transactionDetails as $transactionDetail)
                                    <tr>
                                        <td>
                                            <img src="{{ 'https://ui-avatars.com/api/?name=' . Str::of($transactionDetail->username)->replace(' ', '+') . '&rounded=true' . '&bold=true' }}"
                                                alt="user" height="60" class="rounded-circle">
                                        </td>
                                        <td class="align-middle">{{ $transactionDetail->username }}</td>
                                        @if ($transaction->user->username !== $transactionDetail->username &&
                                        $transaction->status === 'IN CART')
                                        <td class="align-middle">
                                            <form
                                                action="{{ route('checkout.remove', [$transaction->invoice_number, $transactionDetail->username]) }}"
                                                method="POST" onsubmit="return submitted(this)" id="myfr">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="border-0" id="btnfr" title="Hapus member">
                                                    <i class="fas fa-times fa-2x"></i>
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="member mt-3">
                            @if ($transaction->status === 'IN CART')
                            <h2 class="my-3">Tambah Member</h2>
                            <div class="row">
                                <div class="col-md-10">
                                    <form action="{{ route('checkout.create', $transaction->invoice_number) }}"
                                        method="POST" class="form-inline" onsubmit="return submitted(this)" id="myfr">
                                        @csrf
                                        <label class="sr-only" for="username">Username</label>
                                        <input type="text" name="username"
                                            class="form-control mb-2 mr-sm-3 @error('username') is-invalid @enderror"
                                            id="username" placeholder="Username" value="{{ old('username') }}">

                                        <button type="submit" class="btn btn-add-now px-3 mb-2"
                                            id="btnfr">Tambah</button>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </form>
                                </div>
                            </div>
                            <h3 class="mb-0 font-weight-bold mt-3">Catatan</h3>
                            <p class="mb-0">
                                <small class="disclaimer text-bold text-dark-blue">
                                    *Anda hanya dapat mengundang member yang telah terdaftar
                                </small>
                            <p>
                                @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-detail card-right">
                        <h2>Informasi Pembayaran</h2>
                        <hr>
                        <table class="trip-information checkout-information">
                            <tr>
                                <th width="50%">Jumlah Member</th>
                                <td width="50%" class="text-right">
                                    {{ $transaction->transactionDetails()->count() }} orang
                                </td>
                            </tr>
                            <tr>
                                <th width="50%">Harga Perjalanan</th>
                                <td width="50%" class="text-right">
                                    @convertCurrency($transaction->travelPackage->price) {{ __(' / Person') }}
                                </td>
                            </tr>
                            <tr>
                                <th width="50%">Total</th>
                                <td width="50%" class="text-right text-total">
                                    <span class="total-unique1">
                                        @convertCurrency($transaction->total)
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                    @if ($transaction->status === 'IN CART')
                    <div class="join-container">
                        <form action="{{ route('checkout.payment', $transaction->invoice_number) }}" method="POST"
                            onsubmit="return submitted(this)" id="myfr">
                            @csrf
                            <button type="submit" class="btn btn-block btn-join-now mt-3 py-2 border-0" id="btnfr">
                                Go to payment
                            </button>
                        </form>
                    </div>
                    <div class="text-center mt-4">
                        <form action="{{ route('checkout.cancel', $transaction->invoice_number) }}" method="POST"
                            onsubmit="return submitted(this)" id="myfr">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-muted btn btn-block btn-cancel-payment border-0"
                                id="btnfr">
                                Cancel
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            <!-- End Gallery Travel -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
