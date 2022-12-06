@extends('layouts.backend.master-backend')

@section('title', 'Form Profil')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content section-front-profile">
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ __('Profile') }}</h1>
            </div>

            <!-- Profile Form -->
            <x-profiles.card-edit-profile :user="$user" />
            <!-- End profile form -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
