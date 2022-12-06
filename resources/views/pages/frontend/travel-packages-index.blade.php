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
                        @forelse ($travelPackages as $travelPackage)
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card-travel-list text-center d-flex flex-column"
                                style="background-image: url('{{ $travelPackage->firstTravelGallery ? $travelPackage->firstTravelGallery->getImage() : asset('assets/frontend/images/travel/default-travel-image.png') }}');">
                                <div class="travel-text py-2">
                                    <div class="travel-country">{{ $travelPackage->location }}</div>
                                    <div class="travel-location">{{ $travelPackage->title }}</div>
                                </div>
                                <div class="travel-button mt-auto">
                                    <a href="{{ route('travel-packages.front.detail', $travelPackage->slug) }}"
                                        class="btn btn-travel-detail px-4">View Detail</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="card-travel-list text-center d-flex flex-column"
                                style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}');">
                                <div class="travel-text py-2">
                                    <div class="travel-country">DEFAULT</div>
                                    <div class="travel-location">DEFAULT</div>
                                </div>
                                <div class="travel-button mt-auto">
                                    <a href="#" class="btn btn-travel-detail px-4">View Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforelse
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
