@extends('layouts.frontend.master-frontend')

@section('title', 'Form Profil')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content section-front-profile">
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
                                Profile
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- </div> -->
            <!-- End Breadcrumb -->

            @if (session('verifiedStatus'))
            <div class="alert alert-success alert-dismissible fade shown py-3" role="alert">
                {!! session('verifiedStatus') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Profile Forms -->
            <x-profiles.card-edit-profile :user="$user" />
            <!-- End profile forms -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
