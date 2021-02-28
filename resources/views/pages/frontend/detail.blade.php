@extends('layouts.frontend.master-frontend')

@section('title', 'Detail Travel')

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
                            <li class="breadcrumb-item active">
                                Detail
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- End Breadcrumb -->

            <!-- Gallery Travel -->
            <div class="row">
                <div class="col-lg-8 pl-lg-0 mb-3 mb-lg-0">
                    <div class="card card-detail">
                        <h1>Nusa Penida</h1>
                        <p>Republik of Indonesia Raya</p>

                        <div class="gallery">
                            <div class="xzoom-container">
                                <img src="{{ asset('assets/frontend/images/travel/preview/pop1.jpg') }}"
                                    alt="destination" class="xzoom img-fluid" id="xzoom-default"
                                    xoriginal="{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}">
                                <div class="xzoom-thumbs">
                                    <a href="{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}">
                                        <img src="{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}"
                                            alt="image thumbnails" class="xzoom-gallery" width="128"
                                            xpreview="{{ asset('assets/frontend/images/travel/preview/pop1.jpg') }}">
                                    </a>
                                    <a href="{{ asset('assets/frontend/images/travel/original/pop1.2.jpg') }}">
                                        <img src="{{ asset('assets/frontend/images/travel/preview/pop1.2.jpg') }}"
                                            alt="image thumbnails" class="xzoom-gallery" width="128">
                                    </a>
                                    <a href="{{ asset('assets/frontend/images/travel/original/pop1.3.jpg') }}">
                                        <img src="{{ asset('assets/frontend/images/travel/preview/pop1.3.jpg') }}"
                                            alt="image thumbnails" class="xzoom-gallery" width="128">
                                    </a>
                                    <a href="{{ asset('assets/frontend/images/travel/original/pop1.4.jpg') }}">
                                        <img src="{{ asset('assets/frontend/images/travel/preview/pop1.4.jpg') }}"
                                            alt="image thumbnails" class="xzoom-gallery" width="128">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <h2>Tentang Wisata</h2>
                        <p>Nusa Penida is an island southeast of indonesia's island Bali and a district of Klungkung
                            Regency that includes the neightbouring small island of Nusa Lembongan. The Badung
                            Straits
                            separates the island and Bali. The interior of Nusa Penida is hilly with a maximum
                            altitude of
                            42 metres. It is dries than nearby island of Bali.</p>
                        <p>Bali and a district of Klungkung Regency that includes the neightbouring small island of
                            Nusa
                            Lembongan. The Badung Straits separates the island and Bali.</p>

                        <div class="features row">
                            <div class="col-md-4 py-3">
                                <div class="description">
                                    <i class="fas fa-ticket-alt fa-2x features-image"></i>
                                    <div class="description">
                                        <h3>Featured Event</h3>
                                        <p>Tari Kecak</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 py-3 border-left">
                                <div class="description">
                                    <i class="fas fa-language fa-2x features-image"></i>
                                    <div class="description">
                                        <h3>Language</h3>
                                        <p>Bahasa Indonesia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 py-3 border-left">
                                <div class="description">
                                    <i class="fas fa-utensils fa-2x features-image"></i>
                                    <div class="description">
                                        <h3>Foods</h3>
                                        <p>Local Foods</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-detail card-right">
                        <h2>Informasi Trip</h2>
                        <hr>
                        <table class="trip-information">
                            <tr>
                                <th width="50%">Tanggal Keberangkatan</th>
                                <td width="50%" class="text-right">22 Agustus, 2019</td>
                            </tr>
                            <tr>
                                <th width="50%">Durasi</th>
                                <td width="50%" class="text-right">4 Hari, 3 Malam</td>
                            </tr>
                            <tr>
                                <th width="50%">Tipe</th>
                                <td width="50%" class="text-right">Open Trip</td>
                            </tr>
                            <tr>
                                <th width="50%">Harga</th>
                                <td width="50%" class="text-right">Rp 1.125.000 / Orang</td>
                            </tr>
                        </table>
                    </div>
                    <div class="join-container">
                        <a href="{{ route('checkout') }}" class="btn btn-block btn-join-now mt-3 py-2">
                            Gabung Sekarang
                        </a>
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
<!-- Xzoom CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/libraries/xzoom/xzoom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/libraries/xzoom/magnific-popup/css/magnific-popup.css') }}">
@endpush

@push('addon_scripts')
<!-- Xzoom jquery library -->
<script src="{{ asset('assets/frontend/libraries/xzoom/xzoom.min.js') }}"></script>
<script src="{{ asset('assets/frontend/libraries/xzoom/magnific-popup/js/magnific-popup.js') }}"></script>

<script>
    $(document).ready(function () {
                const instance = $('.xzoom, .xzoom-gallery').xzoom({
                    zoomWidth: 500,
                    title: false,
                    tint: '#333',
                    Xoffset: 15,
                    fadeIn: true,
                    fadeTrans: true,
                    fadeOut: true
                });

                $('#xzoom-default').bind('click', function () {
                    const xzoom = $(this).data('xzoom');
                    xzoom.closezoom();
                    const gallery = xzoom.gallery().cgallery;
                    let i, images = new Array();
                    for (i in gallery) {
                        images[i] = { src: gallery[i] };
                    }
                    $.magnificPopup.open({ items: images, type: 'image', gallery: { enabled: true } });
                    event.preventDefault();
                });
            });
</script>
@endpush
