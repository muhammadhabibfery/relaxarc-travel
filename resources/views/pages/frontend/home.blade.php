@extends('layouts.frontend.master-frontend')

@section('title', 'RelaxArc')

@section('content')

<!-- Header -->
<header class="text-center">
    <div class="bg-text-md">
        <h1>Explore The Beautiful World <br> As Easy One Click</h1>
        <p class="mt-3">You will see beautiful <br> moment you never see before</p>
        <a href="#popular-heading" class="btn btn-started px-4 mt-4">Get Started</a>
    </div>
</header>
<!-- End  Header -->

<!-- Content -->
<main>
    <!-- Statistics -->
    <div class="container">
        <section class="section-stats row justify-content-center text-center" id="stats">
            <div class="col-md-3 stats-detail">
                <h2>{{ $memberCount }}</h2>
                <p>Members</p>
            </div>
            <div class="col-md-3 stats-detail">
                <h2>{{ $travelPackages->count() }}</h2>
                <p>Destination</p>
            </div>
            <div class="col-md-3 stats-detail">
                <h2>{{ $travelPackages->count() * 2}}</h2>
                <p>Hotel</p>
            </div>
        </section>
    </div>
    <!-- End  Statistics -->

    <!-- Popular -->
    <section class="section-popular" id="popular">
        <div class="container">
            <div class="row">
                <div class="col text-center section-popular-heading" id="popular-heading">
                    <h2>Wisata Popular</h2>
                    <p>Something that you never try
                        <br>
                        before in this world
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="section-popular-travel" id="popular-travel">
        <div class="container">
            <div class="row justify-content-center section-popular-content">
                @forelse ($travelPackages as $travelPackage)
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column"
                        style="background-image: url('{{ $travelPackage->firstTravelGallery ? $travelPackage->firstTravelGallery->getImage() : asset('assets/frontend/images/travel/default-travel-image.png') }}');">
                        <div class="travel-text py-2">
                            <div class="travel-country">{{ $travelPackage->location }}</div>
                            <div class="travel-location">{{ $travelPackage->title }}</div>
                        </div>
                        <div class="travel-button mt-auto">
                            <a href="{{ route('travel-packages.front.detail', $travelPackage->slug) }}"
                                class="btn btn-travel-detail px-4">Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column"
                        style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}');">
                        <div class="travel-text py-2">
                            <div class="travel-country">DEFAULT</div>
                            <div class="travel-location">DEFAULT</div>
                        </div>
                        <div class="travel-button mt-auto">
                            <a href="#" class="btn btn-travel-detail px-4">Detail</a>
                        </div>
                    </div>
                </div>
                @endforelse

                <a href="{{ route('travel-packages.front.index') }}"
                    class="btn btn-block btn-travel-list py-2 my-3 mx-3">
                    <span class="text-list">Lihat Selengkapnya</span>
                </a>
            </div>
        </div>
    </section>
    <!-- End Popular -->

    <!-- Testimonial -->
    <section class="section-testimonial-heading" id="testimonial-heading">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Testimonial</h2>
                    <p>
                        Moments were giving them
                        <br>
                        the best experience
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-testimonial-content" id="testimonial-content">
        <div class="container">
            <div class="row justify-content-center section-popular-travel">
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="{{ asset('assets/frontend/images/profile.jpg') }}" alt="user"
                                class="mb-4 rounded-circle img-fluid">
                            <h3 class="mb-4">Fery Leonardo</h3>
                            <p class="testimonial">
                                " It was glorius and I could not stop to say wohooo for every single moment Dankeee
                                "
                            </p>
                        </div>
                        <hr>
                        <p class="trip-to mt-2">
                            Trip to Ubud
                        </p>
                    </div>
                </div>
            </div>

            @guest
            <div class="row">
                <div class="col-12 text-center mt-5">
                    <a href="{{ route('contact') }}" class="btn btn-need-help px-4 mx-4 my-3">Butuh Bantuan</a>
                    <a href="{{ route('login') }}" class="btn btn-get-started px-4 mx-4">Mulai Perjalanan</a>
                </div>
            </div>
            @endguest

        </div>
    </section>
    <!-- End Testimonial -->
</main>
<!-- End Content -->
@endsection
