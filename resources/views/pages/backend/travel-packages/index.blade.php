@extends('layouts.backend.master-backend')

@section('title', 'Manage Travel Packages')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Manage travel packages') }}</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">

        <!-- Mobile Searchbar -->
        <div class="col-sm-12 d-sm-block d-md-none">
            <form action="{{ route('travel-packages.index') }}" method="GET">
                <div class="form-group">
                    <label for="keyword" class="sr-only"></label>
                    <input type="text" name="keyword" class="form-control w-100" id="keyword"
                        placeholder="{{ __('Search by title / location') }}" value="{{ request()->keyword }}">
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" class="form-check-input" id="active" value=">" {{
                        request()->status == '>' ? 'checked' : '' }}>
                    <label for="active" class="form-check-label">{{ __('AVAILABLE') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" class="form-check-input" id="inactive" value="<" {{
                        request()->status == '<' ? 'checked' : '' }}>
                        <label for="inactive" class="form-check-label">{{ __('EXPIRED') }}</label>
                </div>
                <div class="form-group mt-3">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block mx-2" type="submit" id="button-addon2">{{
                                __('Search') }}</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('travel-packages.index') }}" class="btn btn-dark btn-block d-inline-block"
                                id="button-addon2">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Desktop Searchbar -->
        <div class="col-md-11 d-none d-md-block">
            <form action="{{ route('travel-packages.index') }}" method="GET" class="form-inline">
                <label for="keyword" class="sr-only"></label>
                <input type="text" name="keyword" class="form-control w-50" id="keyword"
                    placeholder="{{ __('Search by title or location') }}" value="{{ request()->keyword }}">
                <div class="form-check form-check-inline ml-4">
                    <input type="radio" name="status" class="form-check-input" id="available" value=">" {{
                        request()->status == '>' ? 'checked' : '' }}>
                    <label for="available" class="form-check-label">{{ __('AVAILABLE') }}</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="status" class="form-check-input" id="expired" value="<" {{
                        request()->status == '<' ? 'checked' : '' }}>
                        <label for="expired" class="form-check-label">{{ __('EXPIRED') }}</label>
                </div>
                <button class="btn btn-primary mx-2" type="submit" id="button-addon2">{{ __('Search') }}</button>
                <a href="{{ route('travel-packages.index') }}" class="btn btn-dark d-inline-block"
                    id="button-addon2">Reset</a>
            </form>
        </div>

        <div class="col-md-11 my-4">
            <a href="{{ route('travel-packages.create') }}" class="btn btn-dark-blue btn-block">{{ __('Add new travel
                packages') }}</a>
            @if (checkRoles(["ADMIN", "SUPERADMIN", 2], auth()->user()->roles))
            <a href="{{ route('travel-packages.trash') }}" class="btn btn-orange btn-block mt-3">{{ __('Travel packages
                deleted') }}</a>
            @endif
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
                                    <th scope="col">{{ __('Date of departure') }}</th>
                                    <th scope="col">{{ __('Duration') }}</th>
                                    <th scope="col">{{ __('Price') }}</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($travelPackages as $travelPackage)
                                <tr>
                                    <th scope="row">{{ $travelPackages->currentPage() * 10 - 10 + $loop->iteration }}
                                    </th>
                                    <td>{{ $travelPackage->title }}</td>
                                    <td>{{ $travelPackage->location }}</td>
                                    <td>{{ $travelPackage->date_departure_with_day }}</td>
                                    <td>
                                        {{ $travelPackage->duration }}
                                    </td>
                                    <td>
                                        @convertCurrency($travelPackage->price)
                                    </td>
                                    <td>
                                        <p
                                            class="text-bold {{ $travelPackage->date_departure > now() ? ' text-primary' : ' text-danger' }}">
                                            {{ $travelPackage->date_departure > now() ? __('AVAILABLE') : __('EXPIRED')
                                            }}
                                        </p>
                                    </td>
                                    <td>
                                        <a href="{{ route('travel-packages.show', $travelPackage) }}"
                                            class="btn btn-success btn-sm my-1">Detail</a>
                                        <a href="{{ route('travel-packages.edit', $travelPackage) }}"
                                            class="btn btn-warning btn-sm my-1">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm my-1" data-toggle="modal"
                                            data-target="#deletetravelpackage{{ $travelPackage->slug }}Modal">{{
                                            __('Delete') }}</a>
                                    </td>

                                    {{-- Delete Travel Package Modal --}}
                                    <div class="modal fade" id="deletetravelpackage{{ $travelPackage->slug }}Modal"
                                        tabindex="-1" role="dialog" aria-labelledby="deletetravelpackageModalLabel"
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
                                                    <p>{{ __('Are you sure want to delete ?', ['data' => 'paket travel',
                                                        'name' => $travelPackage->title]) }}
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <form
                                                        action="{{ route('travel-packages.destroy', $travelPackage) }}"
                                                        method="POST" onsubmit="return submitted(this)" id="myfr">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-primary" id="btnfr">{{
                                                            __('Delete') }}</button>
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
                                            {{ __('Travel packages not available') }}</p>
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
