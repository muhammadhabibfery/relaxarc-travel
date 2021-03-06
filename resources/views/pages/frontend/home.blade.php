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
            <div class="col-sm-3 col-md-2 stats-detail">
                <h2>20K</h2>
                <p>Members</p>
            </div>
            <div class="col-sm-3 col-md-2 stats-detail">
                <h2>12</h2>
                <p>Countries</p>
            </div>
            <div class="col-sm-3 col-md-2 stats-detail">
                <h2>3K</h2>
                <p>Hotel</p>
            </div>
            <div class="col-sm-3 col-md-2 stats-detail">
                <h2>72</h2>
                <p>Members</p>
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
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column"
                        style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}');">
                        <div class="travel-text py-2">
                            <div class="travel-country">INDONESIA</div>
                            <div class="travel-location">DERATAN, BALI</div>
                        </div>
                        <div class="travel-button mt-auto">
                            <a href="{{ route('detail') }}" class="btn btn-travel-detail px-4">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column"
                        style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop2.jpg') }}');">
                        <div class="travel-text py-2">
                            <div class="travel-country">INDONESIA</div>
                            <div class="travel-location">BROMO, MALANG</div>
                        </div>
                        <div class="travel-button mt-auto">
                            <a href="{{ route('detail') }}" class="btn btn-travel-detail px-4">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column"
                        style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop3.jpg') }}');">
                        <div class="travel-text py-2">
                            <div class="travel-country">INDONESIA</div>
                            <div class="travel-location">NUSA PENIDA</div>
                        </div>
                        <div class="travel-button mt-auto">
                            <a href="{{ route('detail') }}" class="btn btn-travel-detail px-4">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card-travel text-center d-flex flex-column"
                        style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop4.jpg') }}');">
                        <div class="travel-text py-2">
                            <div class="travel-country">INDONESIA</div>
                            <div class="travel-location">GILI TRAWANGAN, NUSA TENGGARA BARAT</div>
                        </div>
                        <div class="travel-button mt-auto">
                            <a href="{{ route('detail') }}" class="btn btn-travel-detail px-4">Detail</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('travels') }}" class="btn btn-block btn-travel-list py-2 my-3 mx-3"><span
                        class="text-list">Lihat
                        Selengkapnya</span></a>
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
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="{{ asset('assets/frontend/images/profile.jpg') }}" alt="user"
                                class="mb-4 rounded-circle img-fluid">
                            <h3 class="mb-4">Mahmud Alexander</h3>
                            <p class="testimonial">
                                " Is simply dummy text of the printing and typesetting industry "
                            </p>
                        </div>
                        <hr>
                        <p class="trip-to mt-2">
                            Trip to Bromo
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="card card-testimonial text-center">
                        <div class="testimonial-content">
                            <img src="{{ asset('assets/frontend/images/profile.jpg') }}" alt="user"
                                class="mb-4 rounded-circle img-fluid">
                            <h3 class="mb-4">Jonathan Juki</h3>
                            <p class="testimonial">
                                " It has survived not only five centuries, but also the leap into electronic
                                typesetting "
                            </p>
                        </div>
                        <hr>
                        <p class="trip-to mt-2">
                            Trip to Malioboro
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
