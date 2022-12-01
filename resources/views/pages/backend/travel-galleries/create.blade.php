@extends('layouts.backend.master-backend')

@section('title', 'Create Travel Galleries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Add new travel galleries') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mt-0">
                <div class="card-body">
                    <form action="{{ route('travel-galleries.store') }}" method="POST" id="myfr"
                        onsubmit="return submitted(this)" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="travel_package">{{ __('Choose travel package') }}</label>
                            <select name="travel_package"
                                class="form-control @error('travel_package') is-invalid @enderror" id="travel_package">
                                <option></option>
                                @foreach ($travelPackages as $travelPackage)
                                <option value="{{ $travelPackage->id }}" {{ old('travel_package')==$travelPackage->id ?
                                    'selected' : '' }}>
                                    {{ $travelPackage->title }}</option>
                                @endforeach
                            </select>
                            @error('travel_package')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">{{ __('Choose Image') }}</label>
                            <input type="file" name="image"
                                class="form-control-file @error('image') is-invalid @enderror" id="image">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-primary" id="btnfr">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon_links')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('addon_scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $("#travel_package").select2({
        placeholder: "{{ __('Choose travel package') }}",
        allowClear: true
        });
    });
</script>
@endpush
