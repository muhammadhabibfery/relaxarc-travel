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
                        <p>Trip to Ubud, Bali, Indonesia</p>

                        <div class="attende">
                            <table class="table table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Nama</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{ asset('assets/frontend/images/profile.jpg') }}" alt="user"
                                                height="60" class="rounded-circle">
                                        </td>
                                        <td class="align-middle">Fery Leonardo</td>
                                        <td class="align-middle">
                                            <a href="#" class="btn-remove">
                                                <i class="fas fa-times fa-2x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="{{ asset('assets/frontend/images/profile.jpg') }}" alt="user"
                                                height="60" class="rounded-circle">
                                        </td>
                                        <td class="align-middle">Neymar Jr</td>
                                        <td class="align-middle">
                                            <a href="#" class="btn-remove">
                                                <i class="fas fa-times fa-2x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="member mt-3">
                            <h2 class="my-3">Tambah Member</h2>
                            <div class="row">
                                <div class="col-md-10">
                                    <form action="" method="POST" class="form-inline" id="myfr">
                                        <label class="sr-only" for="username">Username</label>
                                        <input type="text" name="username" class="form-control mb-2 mr-sm-3"
                                            id="username" placeholder="Username">

                                        <button type="submit" class="btn btn-add-now px-3 mb-2"
                                            id="btnfr">Tambah</button>
                                    </form>
                                </div>
                            </div>
                            <h3 class="mb-0 font-weight-bold mt-3">Catatan</h3>
                            <p class="mb-0">
                                <small class="text-danger disclaimer">
                                    Anda hanya dapat mengundang member yang telah terdaftar
                                </small>
                            <p>
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
                                <td width="50%" class="text-right">2 Orang</td>
                            </tr>
                            <tr>
                                <th width="50%">Harga Perjalanan</th>
                                <td width="50%" class="text-right">Rp 1.125.000 / Orang</td>
                            </tr>
                            <tr>
                                <th width="50%">Sub Total</th>
                                <td width="50%" class="text-right">Rp 2.250.000</td>
                            </tr>
                            <tr>
                                <th width="50%">Total (+Unique)</th>
                                <td width="50%" class="text-right text-total">
                                    <span class="total-unique1">Rp 2.250.<span class="total-unique2">378</span></span>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <h2>Instruksi Pembayaran</h2>
                        <p class="payment-instruction">Selesaikan pembayaran anda sebelum melanjutkan perjalanan
                            yang indah
                        </p>
                        <div class="bank">
                            <div class="bank-item pb-3">
                                <div class="row">
                                    <div class="col-2 mr-1">
                                        <i class="fas fa-credit-card fa-2x"></i>
                                    </div>
                                    <div class="col-8">
                                        <div class="description">
                                            <h3>PT RelaxArc ID</h3>
                                            <p>
                                                0812 3456 7890
                                                <br>
                                                Bank Central Asia
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bank-item pb-3">
                                <div class="row">
                                    <div class="col-2 mr-1">
                                        <i class="fas fa-credit-card fa-2x"></i>
                                    </div>
                                    <div class="col-8">
                                        <div class="description">
                                            <h3>PT RelaxArc ID</h3>
                                            <p>
                                                0899 8888 7777
                                                <br>
                                                Bank Rakyat Indonesia
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="join-container">
                        <a href="{{ route('checkout.success') }}" class="btn btn-block btn-join-now mt-3 py-2">
                            Konfirmasi Pembayaran
                        </a>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('detail') }}" class="text-muted btn-cancel-payment">Batalkan Pembayaran</a>
                    </div>
                </div>
            </div>
            <!-- End Gallery Travel -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
