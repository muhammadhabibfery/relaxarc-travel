@extends('layouts.frontend.master-frontend')

@section('title', 'Kontak Kami')

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

            <!-- Contact -->
            <div class="row">
                <div class="col-lg-7 pl-lg-0 mb-3 mb-lg-0">
                    <div class="card card-detail">
                        <div class="card-header align-items-center">
                            <i class="fas fa-envelope fa-2x"></i>
                            <h2 class="d-inline-block ml-3">Kontak Kami</h2>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group">
                                    <label for="hp">No. Handphone</label>
                                    <input type="number" class="form-control" id="hp">
                                </div>
                                <div class="form-group">
                                    <label for="message">Pesan</label>
                                    <textarea class="form-control" id="message" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-block btn-orange">Kirim</button>
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
