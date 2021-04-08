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
                            <button class="btn btn-primary btn-block mx-2" type="submit"
                                id="button-addon2">{{ __('Search') }}</button>
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
            <a href="{{ route('travel-galleries.create') }}"
                class="btn btn-dark-blue btn-block">{{ __('Add new travel galleries') }}</a>
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
                                    <th scope="col">{{ __('Image') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($travelPackages as $travelPackage)
                                <tr>
                                    <th scope="row">{{ $travelPackages->currentPage() * 10 - 10 + $loop->iteration }}
                                    </th>
                                    <td>{{ $travelPackage->title }}</td>
                                    <td>
                                        <table class="table table-hover text-center">
                                            @forelse ($travelPackage->travelGalleries as $travelGallery)
                                            <tr>
                                                <td width=70%>{{ $travelGallery->name }}</td>
                                                <td width=30%>
                                                    <a href="{{ route('travel-galleries.show', $travelGallery) }}"
                                                        class="btn btn-success btn-sm my-1">Detail</a>
                                                    <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                                        data-target="#deletetravelgallery{{ $travelGallery->slug }}Modal">{{ __('Delete') }}</a>
                                                </td>
                                            </tr>
                                            {{-- Delete Travel Package Modal --}}
                                            <div class="modal fade"
                                                id="deletetravelgallery{{ $travelGallery->slug }}Modal" tabindex="-1"
                                                role="dialog" aria-labelledby="deletetravelgalleryModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('Delete Travel Package') }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>{{ __('Are you sure want to delete ?', ['data' => 'galeri travel', 'name' => $travelGallery->name]) }}
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form
                                                                action="{{ route('travel-galleries.destroy', $travelGallery) }}"
                                                                method="POST" onsubmit="return submitted(this)"
                                                                id="myfr">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-primary"
                                                                    id="btnfr">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <td colspan="6">
                                                <p class="font-weight-bold text-center text-monospace">
                                                    {{ __('Travel galleries :TravelPackage not available', ['travelPackage' => $travelPackage->title]) }}
                                                </p>
                                            </td>
                                            @endforelse
                                        </table>
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
