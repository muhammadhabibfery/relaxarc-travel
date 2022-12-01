@extends('layouts.backend.master-backend')

@section('title', 'Travel packages deleted')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- Desktop Heading -->
    <div class="d-sm-flex d-lg-flex d-xl-flex d-md-none align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Travel packages deleted') }}</h1>
    </div>

    <!-- Mobile Heading -->
    <div class="row d-none d-md-flex d-lg-none mb-4">
        <div class="col-md-8">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Travel packages deleted') }}</h1>
        </div>
        <div class="col-md-4">
            <div class="float-md-right">
                <a href="{{ route('travel-packages.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile or Desktop Searchbar -->
        <x-travel-packages.search-bar :route="route('travel-packages.trash')" file='trash' />

        @isset($error)
        <div class="col-md-8">
            <div class="alert alert-danger alert-dismissible fade show mt-4 text-center" role="alert">
                {!! $error !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endisset

        <div class="col-md-12 mt-md-4">
            <div class="card mt-0">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Location') }}</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deletedTravelPackages as $deletedTravelPackage)
                                <tr>
                                    <th scope="row">
                                        {{ $deletedTravelPackages->currentPage() * 10 - 10 + $loop->iteration }}
                                    </th>
                                    <td>{{ $deletedTravelPackage->title }}</td>
                                    <td>{{ $deletedTravelPackage->location }}</td>
                                    <td>
                                        <p
                                            class="text-bold {{ $deletedTravelPackage->date_departure_status == 'AVAILABLE' ? ' text-primary' : ($deletedTravelPackage->date_departure_status == 'ONGOING' ? ' text-warning' : ' text-danger')  }}">
                                            {{ $deletedTravelPackage->date_departure_status }}
                                        </p>
                                    </td>
                                    <td>
                                        <a href="{{ route('travel-packages.trash.show', $deletedTravelPackage->slug) }}"
                                            class="btn btn-success btn-sm my-1">Detail</a>
                                        @can('restore', $deletedTravelPackage)
                                        <a href="{{ route('travel-packages.restore', $deletedTravelPackage->slug) }}"
                                            class="btn btn-warning btn-sm my-1"
                                            onclick="return confirm('{{ __('Are you sure want to restore travel package :Title ?', ['title' => $deletedTravelPackage->title]) }}')">{{
                                            __('Restore') }}</a>
                                        @endcan
                                        <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                            data-target="#deletetravelpackage{{ $deletedTravelPackage->slug }}Modal">{{
                                            __('Delete permanently') }}</a>
                                    </td>

                                    <!-- Delete Travel Package Modal -->
                                    <div class="modal fade"
                                        id="deletetravelpackage{{ $deletedTravelPackage->slug }}Modal" tabindex="-1"
                                        role="dialog" aria-labelledby="deletetravelpackageModalLabel"
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
                                                    <p>{{ __('Are you sure want to delete permanently ?', ['data' =>
                                                        'paket travel', 'name' => $deletedTravelPackage->title]) }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <form
                                                        action="{{ route('travel-packages.force-delete', $deletedTravelPackage->slug) }}"
                                                        method="POST" onsubmit="return submitted(this)" id="myfr">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-primary" id="btnfr">{{
                                                            __('Delete permanently') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <p class="font-weight-bold text-center text-monospace">
                                            {{ __('Travel packages deleted not available') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $deletedTravelPackages->withQueryString()->onEachSide(2)->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('addon_links')
@include('pages.backend.travel-packages.includes._select2-style')
@endpush

@push('addon_scripts')
@include('pages.backend.travel-packages.includes._select2-script')
@endpush
