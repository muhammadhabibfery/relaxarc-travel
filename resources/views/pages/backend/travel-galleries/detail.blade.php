@extends('layouts.backend.master-backend')

@section('title', 'Detail Travel Galleries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Detail travel gallery') }}</h1>
        <a href="{{ route('travel-galleries.index') }}"
            class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back') }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">



        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                        {{ __('Travel gallery :Name', ['name' => $travelGallery->name]) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="{{ $travelGallery->getThumbnail() }}" class="card-img" alt="Travel gallery Cover">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">{{ __('Name') }}</h5>
                                        <p class="card-text">
                                            {{ $travelGallery->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <small class="text-muted">
                        {{ __('Created by :Username', ['username' => createdUpdatedDeletedBy($travelGallery->uploaded_by)->username ?? '-']) }}
                    </small>
                    <small class="text-muted float-md-right d-block d-md-inline-block d-lg-inline-block">
                        {{ __('Last updated :Date', ['date' => $travelGallery->updated_at ? $travelGallery->updated_at->diffForHumans() : now()]) }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
