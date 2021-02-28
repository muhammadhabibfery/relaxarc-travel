@extends('layouts.frontend.master-checkout')

@section('title', 'checkout')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content">
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
                                        <th>Negara</th>
                                        <th>Visa</th>
                                        <th>Passport</th>
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
                                        <td class="align-middle">CN</td>
                                        <td class="align-middle">N/A</td>
                                        <td class="align-middle">Active</td>
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
                                        <td class="align-middle">SG</td>
                                        <td class="align-middle">30 Hari</td>
                                        <td class="align-middle">Active</td>
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
                            <h2>Tambah Member</h2>
                            <div class="row">
                                <div class="col-md-10">
                                    <form action="" id="myfr">
                                        <div class="form-group">
                                            <label for="username" class="sr-only">Username</label>
                                            <input type="text" name="" class="form-control" id="username"
                                                placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <label for="visa" class="sr-only">Visa</label>
                                            <select name="" class="form-control select2" id="visa">
                                                <option></option>
                                                <option value="30 Hari">30 Hari</option>
                                                <option value="N/A">N/A</option>
                                            </select>
                                        </div>
                                        <div class="flatpickr input-group mb-3">
                                            <input type="date" class="form-control" placeholder="DOE" data-input>
                                            <div class="input-group-append">
                                                <a class="btn btn-outline-secondary" title="toggle" data-toggle>
                                                    <i class="fas fa-calendar"></i>
                                                </a>
                                                <a class="btn btn-outline-secondary" title="clear" data-clear>
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        </div>


                                        <!-- Desktop Button -->
                                        <button type="submit"
                                            class="btn btn-block  btn-add-now mb-2 mt-1 px-4 d-none d-md-block"
                                            id="btnfr">Tambah</button>
                                        <!-- Mobile Button -->
                                        <button type="submit"
                                            class="btn btn-block btn-add-now mb-2 px-4 d-sm-block d-md-none d-lg-none"
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
                                <th width="50%">VISA (opsional)</th>
                                <td width="50%" class="text-right">Rp 2.672.693</td>
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
                                <div class="clearix"></div>
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
                                <div class="clearix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="join-container">
                        <a href="{{ route('checkout-success') }}" class="btn btn-block btn-join-now mt-3 py-2">
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

@push('addon_links')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('addon_scripts')
<!-- Select2 library -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Flatpickr library -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function () {
                $('.select2').select2({
                    placeholder: 'VISA',
                    allowClear: true
                });
            });

            flatpickr('.flatpickr', {
                minDate: "today",
                altInput: true,
                altFormat: "F j, Y",
                wrap: true,
                disableMobile: true
            });
</script>
@endpush
