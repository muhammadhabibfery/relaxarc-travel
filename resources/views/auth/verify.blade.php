@extends('layouts.frontend.master-frontend')

@section('title', 'Verifikasi Email')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content section-email-verify">
        <div class="container">
            <!-- Breadcrumb -->
            <!-- <div class="container"> -->

            <div class="row">
                <div class="col pl-lg-3">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Home
                            </li>
                            <li class="breadcrumb-item active">
                                Verifikasi Email
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- </div> -->
            <!-- End Breadcrumb -->

            <!-- terms & conditions -->
            <section class="section-travel-list pl-lg-0 mb-3 mb-lg-0">
                <div class="card card-travels card-terms-conditions">
                    <h1 class="mb-4">{{ __('Verifikasi Email Anda') }}</h1>

                    @if (session('resent'))
                    <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                        {{ __('Tautan verifikasi email baru telah dikirim ke alamat email Anda.') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <h6>{{ __('Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi email.') }}
                        {{ __('Jika Anda tidak menerima email') }},</h6>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                            class="btn btn-resend-verification btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk mengirim tautan ulang') }}</button>.
                    </form>
                </div>
            </section>
            <!-- End terms & conditions -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
