@extends('layouts.backend.master-backend')

@section('title', 'Change Password')

@section('content')
<!-- Content -->
<main>
    <!-- Header -->
    <section class="section-detail-header"></section>
    <!-- End Header -->

    <!-- Detail Content -->
    <section class="section-detail-content section-front-profile">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <!-- <div class="container"> -->

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ __('Change password') }}</h1>
            </div>

            <!-- Change Password Forms -->
            <x-profiles.card-edit-password />
            <!-- End change password forms -->
        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
