@extends('layouts.backend.master-backend')

@section('title', 'Detail Travel Galleries')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Detail travel galleries from travel package : :TravelPackage',
            ['TravelPackage' => $title]) }}</h1>
        <a href="{{ route('travel-galleries.index') }}" class="btn btn-secondary d-none d-md-block mr-2">{{ __('Back')
            }}</a>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">



        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive-sm">
                        <table class="table table-hover text-center">
                            @forelse ($travelGalleries as $travelGallery)
                            <tr>
                                <td style="width: 60%">
                                    <img src="{{ $travelGallery->getThumbnail() }}"
                                        class="img-fluid img-thumbnail d-block" alt="Travel gallery Cover">
                                    <h4 class="text-left mt-2">
                                        {{ $travelGallery->name }}
                                    </h4>
                                </td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-danger btn-block" data-toggle="modal"
                                        data-target="#deletetravelgallery{{ $travelGallery->slug }}Modal">{{
                                        __('Delete') }}</a>
                                </td>

                                <div class="modal fade" id="deletetravelgallery{{ $travelGallery->slug }}Modal"
                                    tabindex="-1" role="dialog" aria-labelledby="deletetravelgalleryModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    {{ __('Delete Travel Gallery') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{__('Are you sure want to delete travel gallery :Name ?', ['Name' =>
                                                    $travelGallery->name]) }}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{
                                                    __('Cancel') }}</button>
                                                <form action="{{ route('travel-galleries.destroy', $travelGallery) }}"
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
                                <td colspan="2">
                                    <p class="font-weight-bold text-center text-monospace">
                                        {{ __('Travel galleries not available') }}
                                    </p>
                                </td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
