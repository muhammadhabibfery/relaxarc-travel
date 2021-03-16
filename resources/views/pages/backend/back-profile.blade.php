@extends('layouts.backend.master-backend')

@section('title', 'User Profile')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            @dump($response)
            <img src="{{ 'https://ui-avatars.com/api/?name=' . $nameModifier . '&rounded=true' . '&bold=true' }}"
                alt="user profile">
            <h3>{{ $user->name }}</h3>
            <h4>{{ $nameModifier }}</h4>
        </div>
    </div>
</div>


@endsection
