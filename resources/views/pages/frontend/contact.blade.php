@extends('layouts.frontend.master-frontend')

@section('title', 'Kontak Kami')

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
                                Home
                            </li>
                            <li class="breadcrumb-item active">
                                Kontak
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- End Breadcrumb -->

            @if (session('status'))
            <div class="alert alert-{{ session('color') }} alert-dismissible fade show text-center" role="alert">
                {!! session('status') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Contact -->
            <div class="row">
                <div class="col-lg-7 pl-lg-0 mb-3 mb-lg-0">
                    <div class="card card-detail">
                        <div class="card-header align-items-center">
                            <i class="fas fa-envelope fa-2x"></i>
                            <h2 class="d-inline-block ml-3">Kontak Kami</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('contact.send-mail') }}" method="POST" id="myfr"
                                onsubmit="return submitted(this)">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="hp">No. Handphone</label>
                                    <input type="number" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror" id="hp">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="message">Pesan</label>
                                    <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                        id="message" rows="3"></textarea>
                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-block btn-orange" id="btnfr">Kirim</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-detail card-right">
                        <div class="card-header align-items-center">
                            <i class="fas fa-address-card fa-2x"></i>
                            <h2 class="d-inline-block ml-3">Alamat</h2>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Cengkareng, Jakarta Barat</li>
                                <li class="list-group-item">Indonesia</li>
                                <li class="list-group-item">+62812-3456-7890</li>
                                <li class="list-group-item">support@relaxarc.id</li>
                            </ul>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <!-- End Contact -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
