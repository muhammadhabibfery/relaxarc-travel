@extends('layouts.backend.master-backend')

@section('title', 'Detail Travel Packages')

@section('content')
<div class="container-fluid">

    <!--Page Heading & Content Detail -->
    <x-transactions.card-detail :transaction="$deletedTransaction" :route="route('transactions.trash')" />

</div>
@endsection
