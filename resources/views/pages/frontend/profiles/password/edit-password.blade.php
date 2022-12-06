@extends('layouts.frontend.master-frontend')

@section('title', 'Change Password')

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
                                Change Password
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- </div> -->
            <!-- End Breadcrumb -->

            <!-- Change Password Forms -->
            {{-- <div class="row justify-content-center">
                <div class="col-md-10">
                    <section class="section-travel-list pl-lg-0 mb-3 mb-lg-0">
                        <div class="table-responsive-sm">
                            <div class="card card-travels card-terms-conditions p-3">
                                <div class="row justify-content-end">
                                    <div class="col-8 col-md-4 col-lg-4 col-xl-4">
                                        <a href="#" class="btn btn-secondary float-right d-none d-md-block">{{ __('Back
                                            to home') }}</a>
                                        <a href="#" class="btn btn-secondary float-right d-sm-block d-md-none"><i
                                                class="fas fa-recycle"></i><span class="pl-2">Home</span></a>
                                    </div>
                                </div>

                                <form action="{{ route('update-password') }}" method="POST" id=" myfr"
                                    onsubmit="return submitted(this)">
                                    @method('patch')
                                    @csrf
                                    <div class="form-group">
                                        <label for="current_password">{{ __('Current password') }}</label>
                                        <input type="password" name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password">
                                        @error('current_password')
                                        <span class="invalid-feedback error-background" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">{{ __('New password') }}</label>
                                        <input type="password" name="new_password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new_password">
                                        @error('new_password')
                                        <span class="invalid-feedback error-background" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password_confirmation">{{ __('Password confirmation') }}</label>
                                        <input type="password" name="new_password_confirmation"
                                            class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                            id="new_password_confirmation">
                                        @error('new_password_confirmation')
                                        <span class="invalid-feedback error-background" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="btnfr" class="btn btn-primary btn-block mt-3"
                                            id="btnfr">{{ __('Update') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div> --}}
            <x-profiles.card-edit-password />
            <!-- End change password forms -->

        </div>
    </section>
    <!-- EndDetail Content -->
</main>
<!-- End Content -->
@endsection
