@extends('layouts.frontend.master-frontend')

@section('title', 'Detail Travel')

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
                        <h1>{{ $travelPackage->title }}</h1>
                        <p>{{ $travelPackage->location }}</p>

                        <div class="gallery">
                            @if ($travelPackage->travelGalleries->count())
                            <div class="xzoom-container">
                                <img src="{{ $travelPackage->travelGalleries->first()->getImage() }}" alt="destination"
                                    class="xzoom img-fluid" id="xzoom-default"
                                    xoriginal="{{ $travelPackage->travelGalleries->first()->getThumbnail() }}">
                                <div class="xzoom-thumbs">
                                    @foreach ($travelPackage->travelGalleries as $travelGallery)
                                    <a href="{{ $travelGallery->getThumbnail() }}">
                                        <img src="{{ $travelGallery->getThumbnail() }}" alt="image thumbnails"
                                            class="xzoom-gallery" width="128"
                                            xpreview="{{ $travelGallery->getImage() }}">
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <img src="{{ asset('assets/frontend/images/travel/default-travel-image.png') }}"
                                alt="destination" class="img-fluid">
                            @endif
                        </div>

                        <h2>Tentang Wisata</h2>
                        <p>{!! $travelPackage->about !!}</p>
                        <div class="features row">
                            <div class="col-md-4 py-3">
                                <div class="description">
                                    <i class="fas fa-ticket-alt fa-2x features-image"></i>
                                    <div class="description">
                                        <h3>Featured Event</h3>
                                        <p>
                                            <x-travel-packages.list-data
                                                :data="transformStringToArray($travelPackage->featured_event, ',')" />
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 py-3 border-left">
                                <div class="description">
                                    <i class="fas fa-language fa-2x features-image"></i>
                                    <div class="description">
                                        <h3>Language</h3>
                                        <p>
                                            <x-travel-packages.list-data
                                                :data="transformStringToArray($travelPackage->language, ',')" />
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 py-3 border-left">
                                <div class="description">
                                    <i class="fas fa-utensils fa-2x features-image"></i>
                                    <div class="description">
                                        <h3>Foods</h3>
                                        <p>
                                            <x-travel-packages.list-data
                                                :data="transformStringToArray($travelPackage->foods, ',')" />
                                        </p>
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
                                <td width="50%" class="text-right">{{ $travelPackage->date_departure_with_day }}</td>
                            </tr>
                            <tr>
                                <th width="50%">Durasi</th>
                                <td width="50%" class="text-right">
                                    {{ formatTravelPackageDuration($travelPackage->duration, app()->getLocale()) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="50%">Tipe</th>
                                <td width="50%" class="text-right">{{ $travelPackage->type }}</td>
                            </tr>
                            <tr>
                                <th width="50%">Harga</th>
                                <td width="50%" class="text-right">
                                    @convertCurrency($travelPackage->price) {{ __(' / Person') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="join-container">
                        <form action="{{ route('checkout.proccess', $travelPackage->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-block btn-join-now mt-3 py-2">
                                {{ __('Join now') }}
                            </button>
                        </form>
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
