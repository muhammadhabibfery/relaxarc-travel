@extends('layouts.backend.master-backend')

@section('title', 'Detail Deleted Travel Package')

@section('content')
<div class="container-fluid">

    <x-travel-packages.card-detail :travelPackage="$deletedTravelPackage" :route="route('travel-packages.trash')"
        type="detail-trash" />

</div>
@endsection
