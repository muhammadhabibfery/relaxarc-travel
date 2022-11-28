@extends('layouts.frontend.master-frontend')

@section('title', 'Daftar Paket Travel')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content">
        {{-- <div class="container-fluid"> --}}
            <!-- Breadcrumb -->
            <div class="container">

                <div class="row">
                    <div class="col pl-lg-0">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">
                                    Paket Travel
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- End Breadcrumb -->

            <!-- List of Travel -->
            <section class="section-travel-list pl-lg-0 mb-3 mb-lg-0">
                <div class="card card-travels">
                    <h1 class="mb-4">Paket Travel</h1>
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card-travel-list text-center d-flex flex-column"
                                style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}');">
                                <div class="travel-text py-2">
                                    <div class="travel-country">INDONESIA</div>
                                    <div class="travel-location">DERATAN, BALI</div>
                                </div>
                                <div class="travel-button mt-auto">
                                    <a href="{{ route('travel-packages.detail') }}"
                                        class="btn btn-travel-detail px-4">View Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card-travel-list text-center d-flex flex-column"
                                style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop2.jpg') }}');">
                                <div class="travel-text py-2">
                                    <div class="travel-country">INDONESIA</div>
                                    <div class="travel-location">BROMO, MALANG</div>
                                </div>
                                <div class="travel-button mt-auto">
                                    <a href="{{ route('travel-packages.detail') }}"
                                        class="btn btn-travel-detail px-4">View Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card-travel-list text-center d-flex flex-column"
                                style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop3.jpg') }}');">
                                <div class="travel-text py-2">
                                    <div class="travel-country">INDONESIA</div>
                                    <div class="travel-location">NUSA PENIDA</div>
                                </div>
                                <div class="travel-button mt-auto">
                                    <a href="{{ route('travel-packages.detail') }}"
                                        class="btn btn-travel-detail px-4">View Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card-travel-list text-center d-flex flex-column"
                                style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop4.jpg') }}');">
                                <div class="travel-text py-2">
                                    <div class="travel-country">INDONESIA</div>
                                    <div class="travel-location">GILI TRAWANGAN, NUSA TENGGARA BARAT</div>
                                </div>
                                <div class="travel-button mt-auto">
                                    <a href="{{ route('travel-packages.detail') }}"
                                        class="btn btn-travel-detail px-4">View Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End List of Travel -->
            {{--
        </div> --}}
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
