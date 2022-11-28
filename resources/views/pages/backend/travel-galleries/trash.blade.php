@extends('layouts.backend.master-backend')

@section('title', 'Travel packages deleted')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Travel packages deleted') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile Searchbar -->
        <div class="col-sm-12 d-sm-block d-md-none">
            <form action="{{ route('travel-packages.trash') }}" method="GET">
                <div class="form-group">
                    <label for="keyword" class="sr-only"></label>
                    <input type="text" name="keyword" class="form-control w-100" id="keyword"
                        placeholder="{{ __('Search by title / location') }}" value="{{ request()->keyword }}">
                </div>
                <div class="form-group mt-3">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block mx-2" type="submit" id="button-addon2">{{
                                __('Search') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('travel-packages.trash') }}" class="btn btn-dark btn-block d-inline-block"
                                id="button-addon2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
            <a href="{{ route('travel-packages.index') }}" class="btn btn-block btn-secondary my-3">{{ __('Back') }}</a>
        </div>

        <!-- Desktop Searchbar -->
        <div class="col-md-11 d-none d-md-block mb-3">
            <div class="row">
                <div class="col-md-10">
                    <form action="{{ route('travel-packages.trash') }}" method="GET" class="form-inline">
                        <label for="keyword" class="sr-only"></label>
                        <input type="text" name="keyword" class="form-control w-50" id="keyword"
                            placeholder="{{ __('Search by title or location') }}" value="{{ request()->keyword }}">
                        <button class="btn btn-primary mx-2" type="submit" id="button-addon2">{{ __('Search')
                            }}</button>
                        <a href="{{ route('travel-packages.trash') }}" class="btn btn-dark d-inline-block"
                            id="button-addon2">Reset</a>
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="float-md-right">
                        <a href="{{ route('travel-packages.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-11">
            <div class="card mt-0">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Location') }}</th>
                                    <th scope="col">{{ __('Deleted by') }}</th>
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
                                    <td>{{ createdUpdatedDeletedBy($deletedTravelPackage->deleted_by)->username }}</td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm my-1" data-toggle="modal"
                                            data-target="#detailtravelpackage{{ $deletedTravelPackage->slug }}Modal">Detail</a>
                                        <a href="{{ route('travel-packages.restore', $deletedTravelPackage->slug) }}"
                                            class="btn btn-warning btn-sm my-1"
                                            onclick="return confirm('{{ __('Are you sure want to restore travel package :Title ?', ['title' => $deletedTravelPackage->title]) }}')">{{
                                            __('Restore') }}</a>
                                        <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                            data-target="#deletetravelpackage{{ $deletedTravelPackage->slug }}Modal">{{
                                            __('Delete permanently') }}</a>
                                    </td>

                                    {{-- Delete Travel Package Modal --}}
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

                                    {{-- Detail Travel Package Modal --}}
                                    <div class="modal fade"
                                        id="detailtravelpackage{{ $deletedTravelPackage->slug }}Modal" tabindex="-1"
                                        role="dialog" aria-labelledby="DetailtravelpackageModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="DetailtravelpackageModalLabel">
                                                        {{ __('Detail Travel Package', ['name' =>
                                                        $deletedTravelPackage->title]) }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card mb-3">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-4">
                                                                <img src="#" class="card-img"
                                                                    alt="Travel Package Cover">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <h5 class="card-title">{{ __('Name') }}</h5>
                                                                            <p class="card-text">
                                                                                {{ $deletedTravelPackage->title }}
                                                                            </p>
                                                                            <h5 class="card-title">{{ __('Location') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                {{ $deletedTravelPackage->location }}
                                                                            </p>
                                                                            <h5 class="card-title">{{ __('About') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                {{ $deletedTravelPackage->about }}
                                                                            </p>
                                                                            <h5 class="card-title">
                                                                                {{ __('Feautured event') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                @if(is_array($deletedTravelPackage->featured_event))
                                                                            <ul>
                                                                                @foreach($deletedTravelPackage->featured_event
                                                                                as $featured_event)
                                                                                <li>{{ trim(ucfirst($featured_event)) }}
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            @else
                                                                            {{
                                                                            ucfirst($deletedTravelPackage->featured_event)
                                                                            }}
                                                                            @endif
                                                                            </p>
                                                                            <h5 class="card-title">{{ __('Language') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                @if(is_array($deletedTravelPackage->language))
                                                                            <ul>
                                                                                @foreach($deletedTravelPackage->language
                                                                                as
                                                                                $l)
                                                                                <li>{{ trim(ucfirst($l)) }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                            @else
                                                                            {{ ucfirst($deletedTravelPackage->language)
                                                                            }}
                                                                            @endif
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <h5 class="card-title">{{ __('Foods') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                @if(is_array($deletedTravelPackage->foods))
                                                                            <ul>
                                                                                @foreach($deletedTravelPackage->foods
                                                                                as
                                                                                $food)
                                                                                <li>{{ trim(ucfirst($food)) }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                            @else
                                                                            {{ ucfirst($deletedTravelPackage->foods) }}
                                                                            @endif
                                                                            </p>
                                                                            <h5 class="card-title">
                                                                                {{ __('Date of departure') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                {{
                                                                                $deletedTravelPackage->date_departure_with_day
                                                                                }}
                                                                            </p>
                                                                            <h5 class="card-title">{{ __('Duration') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                {{ $deletedTravelPackage->duration }}
                                                                            </p>
                                                                            <h5 class="card-title">{{ __('Type') }}</h5>
                                                                            <p class="card-text">
                                                                                {{ $deletedTravelPackage->type }}
                                                                            </p>
                                                                            <h5 class="card-title">{{ __('Price') }}
                                                                            </h5>
                                                                            <p class="card-text">
                                                                                @convertCurrency($deletedTravelPackage->price)
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <p class="card-text mt-3">
                                                                        <small class="text-muted">
                                                                            {{ __('Created by :name', ['name' =>
                                                                            createdUpdatedDeletedBy($deletedTravelPackage->created_by)->name
                                                                            ?? '-']) }}
                                                                        </small>
                                                                        <small
                                                                            class="text-muted float-md-right d-block d-md-inline-block d-lg-inline-block">
                                                                            @if ($deletedTravelPackage->updated_by)
                                                                            {{ __('Last updated by :Name (:Date)',
                                                                            ['name' =>
                                                                            createdUpdatedDeletedBy($deletedTravelPackage->updated_by)->username,
                                                                            'date' => $deletedTravelPackage->updated_at
                                                                            ?
                                                                            $deletedTravelPackage->updated_at->diffForHumans()
                                                                            : now()]) }}
                                                                            @else
                                                                            {{ __('Last updated :Date', ['date' =>
                                                                            $deletedTravelPackage->updated_at ?
                                                                            $deletedTravelPackage->updated_at->diffForHumans()
                                                                            : now()]) }}
                                                                            @endif
                                                                        </small>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Close') }}</button>
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
