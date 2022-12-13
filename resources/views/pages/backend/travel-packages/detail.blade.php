@extends('layouts.backend.master-backend')

@section('title', 'Detail Travel Packages')

@section('content')
<div class="container-fluid">

    <!--Page Heading & Content Detail -->
    <x-travel-packages.card-detail :travelPackage="$travelPackage" :invoiceNumber="$invoiceNumber" type="detail" />

</div>
@endsection
