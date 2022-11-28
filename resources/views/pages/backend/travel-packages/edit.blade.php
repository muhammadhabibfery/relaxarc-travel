@extends('layouts.backend.master-backend')

@section('title', 'Edit Travel Package')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit travel package') }}</h1>
        <a href="{{ route('travel-packages.index') }}" class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back')
            }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-0">
                <div class="card-body">
                    <form action="{{ route('travel-packages.update', $travelPackage) }}" method="POST" id="myfr"
                        onsubmit="return submitted(this)">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-md-6">
                                <div class=" form-group">
                                    <label for="title">{{ __('Title') }}</label>
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        value="{{ old('title', $travelPackage->title) }}">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="location">{{ __('Location') }}</label>
                                    <input type="text" name="location"
                                        class="form-control @error('location') is-invalid @enderror" id="location"
                                        value="{{ old('location', $travelPackage->location) }}">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="about">{{ __('About') }}</label>
                                    <textarea name="about" class="form-control @error('location') is-invalid @enderror"
                                        id="about" rows="1">{{ old('about', $travelPackage->about) }}</textarea>
                                    @error('about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="featured_event">{{ __('Feautured event') }}</label>
                                    <textarea name="featured_event"
                                        class="form-control @error('featured_event') is-invalid @enderror"
                                        id="featured_event"
                                        rows="1">{{ old('featured_event', $travelPackage->featured_event) }}</textarea>
                                    <small class="form-text text-muted">{{ __("*Use komma ',' to input some data",
                                        ['data' => 'acara']) }}</small>
                                    @error('featured_event')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="language">{{ __('Language') }}</label>
                                    <textarea name="language"
                                        class="form-control @error('language') is-invalid @enderror" id="language"
                                        rows="1">{{ old('language', $travelPackage->language) }}</textarea>
                                    <small class="form-text text-muted">{{ __("*Use komma ',' to input some data",
                                        ['data' => 'bahasa']) }}</small>
                                    @error('language')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="foods">{{ __('Foods') }}</label>
                                    <textarea name="foods" class="form-control @error('foods') is-invalid @enderror"
                                        id="foods" rows="1">{{ old('foods', $travelPackage->foods) }}</textarea>
                                    <small class="form-text text-muted">{{ __("*Use komma ',' to input some data",
                                        ['data' => 'snack/makanan']) }}</small>
                                    @error('foods')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date_departure">{{ __('Date of departure') }}</label>
                                    <div class="input-group flatpickr">
                                        <input type="text" name="date_departure"
                                            class="form-control @error('date_departure') is-invalid @enderror"
                                            id="date_departure"
                                            value="{{ old('date_departure', $travelPackage->date_departure) }}"
                                            placeholder="{{ old('date_departure') ? transformDateFormat(old('date_departure'), 'l, d-F-Y H:i') : $travelPackage->date_departure_with_day }}"
                                            data-input>
                                        <div class="input-group-append" id="button-addon4">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <a class="input-button" title="toggle" data-toggle>
                                                    <i class="far fa-calendar-alt"></i>
                                                </a>
                                            </button>
                                        </div>
                                        @error('date_departure')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="duration">{{ __('Duration') }}</label>
                                    <input type="text" name="duration"
                                        class="form-control @error('duration') is-invalid @enderror" id="duration"
                                        value="{{ old('duration', $travelPackage->duration) }}">
                                    <small class="form-text text-muted">
                                        {{ __("*Only input 2 characters. Ex: 5D (meaning 5 days)") }}
                                    </small>
                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="type">{{ __('Type') }}</label>
                                    <select name="type" class="form-control @error('type') is-invalid @enderror"
                                        id="type">
                                        <option value="">{{ __('Choose type') }}</option>
                                        <option value="Open Trip" {{ $travelPackage->
                                            isMatchType($travelPackage->type, 'Open Trip') ?
                                            ' selected' : '' }}>
                                            Open Trip</option>
                                        <option value="Private Group" {{ $travelPackage->
                                            isMatchType($travelPackage->type, 'Private Group') ? ' selected' : '' }}>
                                            Private Group
                                        </option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price">{{ __('Price') }}</label>
                                    <input type="text" name="price"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        value="{{ old('price', $travelPackage->price) }}" autocomplete="off">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-primary" id="btnfr">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon_links')
@include('pages.backend.travel-packages.includes._flatpickr-jquerymask-styles')
@endpush

@push('addon_scripts')
@include('pages.backend.travel-packages.includes._flatpickr-jquerymask-scripts')
@endpush
