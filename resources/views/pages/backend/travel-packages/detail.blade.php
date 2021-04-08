@extends('layouts.backend.master-backend')

@section('title', 'Detail Travel Packages')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Detail travel packages') }}</h1>
        <a href="{{ route('travel-packages.index') }}"
            class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back') }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">



        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                        {{ __('Detail Travel Package', ['name' => $travelPackage->title]) }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <img src="{{ $travelPackage->travelGalleries()->first() ? $travelPackage->travelGalleries()->first()->getThumbnail() : asset('assets/backend/img/no-image.png') }}"
                                class="card-img" alt="Travel Package Cover">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">{{ __('Name') }}</h5>
                                        <p class="card-text">
                                            {{ $travelPackage->title }}
                                        </p>
                                        <h5 class="card-title">{{ __('Location') }}
                                        </h5>
                                        <p class="card-text">
                                            {{ $travelPackage->location }}
                                        </p>
                                        <h5 class="card-title">{{ __('About') }}
                                        </h5>
                                        <p class="card-text">
                                            {{ $travelPackage->about }}
                                        </p>
                                        <h5 class="card-title">
                                            {{ __('Feautured event') }}
                                        </h5>
                                        <p class="card-text">
                                            @if(is_array($travelPackage->featured_event))
                                            <ul>
                                                @foreach($travelPackage->featured_event
                                                as $featured_event)
                                                <li>{{ trim(ucfirst($featured_event)) }}
                                                </li>
                                                @endforeach
                                            </ul>
                                            @else
                                            {{ ucfirst($travelPackage->featured_event) }}
                                            @endif
                                        </p>
                                        <h5 class="card-title">{{ __('Language') }}
                                        </h5>
                                        <p class="card-text">
                                            @if(is_array($travelPackage->language))
                                            <ul>
                                                @foreach($travelPackage->language as
                                                $l)
                                                <li>{{ trim(ucfirst($l)) }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            {{ ucfirst($travelPackage->language) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title">{{ __('Foods') }}
                                        </h5>
                                        <p class="card-text">
                                            @if(is_array($travelPackage->foods))
                                            <ul>
                                                @foreach($travelPackage->foods as
                                                $food)
                                                <li>{{ trim(ucfirst($food)) }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                            {{ ucfirst($travelPackage->foods) }}
                                            @endif
                                        </p>
                                        <h5 class="card-title">
                                            {{ __('Date of departure') }}
                                        </h5>
                                        <p class="card-text">
                                            {{ $travelPackage->date_departure_with_day }}
                                        </p>
                                        <h5 class="card-title">{{ __('Duration') }}
                                        </h5>
                                        <p class="card-text">
                                            {{ $travelPackage->duration }}
                                        </p>
                                        <h5 class="card-title">{{ __('Type') }}</h5>
                                        <p class="card-text">
                                            {{ $travelPackage->type }}
                                        </p>
                                        <h5 class="card-title">{{ __('Price') }}
                                        </h5>
                                        <p class="card-text">
                                            @convertCurrency($travelPackage->price)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <small class="text-muted">
                        {{ __('Created by :Username', ['username' => createdUpdatedDeletedBy($travelPackage->created_by)->username ?? '-']) }}
                    </small>
                    <small class="text-muted float-md-right d-block d-md-inline-block d-lg-inline-block">
                        @if ($travelPackage->updated_by)
                        {{ __('Last updated by :Name (:Date)', ['name' => createdUpdatedDeletedBy($travelPackage->updated_by)->username, 'date' => $travelPackage->updated_at ? $travelPackage->updated_at->diffForHumans() : now()]) }}
                        @else
                        {{ __('Last updated :Date', ['date' => $travelPackage->updated_at ? $travelPackage->updated_at->diffForHumans() : now()]) }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
