@extends('layouts.backend.master-backend')

@section('title', 'Manage Travel Galleries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Manage travel galleries') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile Searchbar -->
        <div class="col-sm-12 d-sm-block d-md-none">
            <form action="{{ route('travel-galleries.index') }}" method="GET">
                <div class="form-group">
                    <label for="keyword" class="sr-only"></label>
                    <input type="text" name="keyword" class="form-control w-100" id="keyword"
                        placeholder="{{ __('Search travel package') }}" value="{{ request()->keyword }}">
                </div>
                <div class="form-group mt-3">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block mx-2" type="submit" id="button-addon2">{{
                                __('Search') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('travel-galleries.index') }}"
                                class="btn btn-dark btn-block d-inline-block" id="button-addon2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Desktop Searchbar -->
        <div class="col-md-11 d-none d-md-block">
            <form action="{{ route('travel-galleries.index') }}" method="GET" class="form-inline">
                <label for="keyword" class="sr-only"></label>
                <input type="text" name="keyword" class="form-control w-50" id="keyword"
                    placeholder="{{ __('Search travel package') }}" value="{{ request()->keyword }}">
                <button class="btn btn-primary mx-2" type="submit" id="button-addon2">{{ __('Search') }}</button>
                <a href="{{ route('travel-galleries.index') }}" class="btn btn-dark d-inline-block"
                    id="button-addon2">Reset</a>
            </form>
        </div>

        <div class="col-md-11 my-4">
            <a href="{{ route('travel-galleries.create') }}" class="btn btn-dark-blue btn-block">
                {{ __('Add new travel galleries') }}</a>
        </div>

        <div class="col-md-11">
            <div class="card mt-0">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">{{ __('Travel Packages') }}</th>
                                    <th scope="col">{{ __('Total image') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($travelPackages as $travelPackage)
                                <tr>
                                    <th scope="row">{{ $travelPackages->currentPage() * 10 - 10 + $loop->iteration }}
                                    </th>
                                    <td>{{ $travelPackage->title }}</td>
                                    <td>
                                        {{ $travelPackage->travel_galleries_count > 0 ?
                                        $travelPackage->travel_galleries_count : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('travel-galleries.show', $travelPackage) }}"
                                            class="btn btn-success btn-sm my-1">Detail</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2">
                                        <p class="font-weight-bold text-center text-monospace">
                                            {{ __('Travel packages not available') }}
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $travelPackages->withQueryString()->onEachSide(2)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
